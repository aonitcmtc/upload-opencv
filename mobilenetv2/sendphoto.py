import requests
#import os
path = "./img/kkk.jpg"
url='http://35.187.244.60/uploadimg.php'
files = {'uploadfile': open(path,'rb')}
#print (files)
r = requests.post(url, files = files)
print (r.text)

