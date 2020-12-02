import requests

url = 'https://notify-api.line.me/api/notify'
token = '9IBnp37LVHj0a6W5HLq2dF7sqIjGyEVn2DQtpQq7wYv'
headers = {'content-type':'application/x-www-form-urlencoded','Authorization':'Bearer '+token}

msg = 'ทดสอบภาษาไทย hello'
r = requests.post(url, headers=headers , data = {'message':msg})
print r.text
