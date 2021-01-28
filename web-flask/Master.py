from flask import Flask
import os

app = Flask(__name__)


@app.route('/')
def hello_world():
    return 'Hello, World Web Master..!!'


if __name__ == '__main__':
    port = int(os.getenv('PORT', 9000))
    print("Starting app on port %d" % port)
    app.run(debug=True, port=port, host='0.0.0.0', threaded=True)
