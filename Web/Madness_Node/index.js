let express = require('express')
let app = express()
let path = require('path');
let cp = require('cookie-parser');
let b64 = require('base-64')
var bodyParser = require('body-parser')
const port = 3000
app.use(cp());
app.use(bodyParser.urlencoded({ extended: true }))
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname+'/templates/index.html'));
})

app.get('/login',(req,res) => {
    if(!req.cookies['currentUser']) res.sendFile(path.join(__dirname+'/templates/login.html'));
    else res.send("You are already connected. You can see your profile <a href='/profile'>here</a>.");
})

app.post('/login',(req,res) => {
    if(req.body.username != undefined && req.body.password != undefined){
        if(!req.cookies['currentUser']){
            let options = {
                maxAge: 1000 * 60 * 15
            }
            let infos = b64.encode('{"username":"'+req.body.username+'","password":"'+req.body.password+'","isAdmin":0}');
            res.cookie('currentUser',infos,options);
        }
            res.send("Connected! You can see your profile <a href='/profile'>here</a>.");
    }
})

app.get("/profile",(req,res) => {
    if(req.cookies['currentUser']) res.send("Your current informations are : "+b64.decode(req.cookies['currentUser']));
    else res.send("You are not connected. Login first please.");
})

app.get("/admin",(req,res) => {
    if(req.cookies['currentUser']){
        var user = JSON.parse(b64.decode(req.cookies['currentUser']))
        if(user['isAdmin'] == 1){
            res.send("Welcome back admin ! <br>Message of the day : MCTF{d0nt_st0r3_s3ns1t1v3_v4lu3s_1n_c00k13s}")
        }else{
            res.send("You are not an admin ! Get out !")
        }
    }else{
        res.send("Please connect before accessing application <a href='/login'>here</a>.");
    }
})
app.listen(port, () => {
  console.log(`App listening at http://localhost:${port}`)
})
