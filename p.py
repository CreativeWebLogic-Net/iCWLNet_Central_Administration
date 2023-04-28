#!C:\Users\danie\AppData\Local\Programs\Python\Python311\python.exe
import requests

url = 'http://access.sitemanage.info'
response = requests.get(url)

print("Content-type: text/plain; charset=iso-8859-1\n\n")
print("hello world")
print(response.text)