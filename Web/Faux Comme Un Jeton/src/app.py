from flask import Flask, jsonify, request, session, make_response, render_template
from functools import wraps
import jwt
import datetime

app = Flask(__name__,static_url_path='/static')
app.config['SECRET_KEY'] = 'hiorhello21'
private_key = open('key.pem', 'r').read()
public_key = open('public.pem', 'r').read()


@app.route('/')
def index():
    if not session.get('logged_in'):
        return render_template('login.html')
    else:
        return render_template('index.html')


@app.route('/public.pem')
def publicPem():
    return render_template('public.html')


@app.route('/login', methods=['POST'])
def login():
    if (request.form['username'] == 'user1' and request.form['password'] == 'user1') or (request.form['username'] == 'user2' and request.form['password'] == 'user2'):
        session['logged_in'] = True
        token = jwt.encode({
            'user': request.form['username'],
            'exp': datetime.datetime.utcnow() + datetime.timedelta(seconds=60),
            'isAdmin': 0
        },
            private_key
            ,algorithm="RS256"
            )

        resp = make_response(render_template('index.html'))
        resp.set_cookie('token',token)
        return resp
    else:
        return make_response('Invalid credentials.', 403, {'WWW-Authenticate': 'Basic realm "Login"'})


@app.route('/admin', methods=['POST'])
def admin():
    token = request.cookies['token']
    try:
        data = jwt.decode(token, public_key)
        if data:
            if data['isAdmin'] == 1:
                return render_template('admin.html')
            else:
                return make_response('Unable to verify', 403, {'WWW-Authenticate': 'Basic realm "Login"'})
        else:
            return make_response('Unable to verify', 403, {'WWW-Authenticate': 'Basic realm "Login"'})
    except:
        return make_response('Unable to verify', 403, {'WWW-Authenticate': 'Basic realm "Login"'})


if __name__ == '__main__':
    app.run(host='0.0.0.0',port=5000)
