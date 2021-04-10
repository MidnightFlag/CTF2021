#!/bin/bash
docker exec -dit saignant bash -c "while true; do curl -k https://localhost/7cf8a002dbc08c3f31aca619141d141d/; sleep 2; done"
