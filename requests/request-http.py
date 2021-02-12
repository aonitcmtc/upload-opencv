import requests

apiKeyValue = "tPmAT5Ab3j7F9";

cam = 1
view = 2
person = 3

url = 'http://35.187.244.60/class3-post.php'
myobj = {'api_key': apiKeyValue ,'camera': cam ,'view': view ,'person': person}

x = requests.post(url, data = myobj)

#print the response text (the content of the requested file):
print(x.text)









