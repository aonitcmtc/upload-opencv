from flask import Flask, render_template,request,redirect,url_for
import pymysql
#import time
import os


app = Flask(__name__,template_folder='template') #
#conn = pymysql.connect(db='person_data', user='root', passwd='605232060', host='localhost', port=3306)
conn = pymysql.connect(host='localhost',user='root',password='605232060',database='person_data' ,port=3306)

@app.route('/')
def index():
    with conn.cursor() as cursor:
        cursor = conn.cursor()
        cursor.execute("SELECT * FROM person")
        row = cursor.fetchall()
        return render_template('index.html', datas=row)

@app.route('/from')
def addfrom():
    return render_template('add.html')

@app.route('/insert',methods=['POST'])
def insert():
    if request.method == "POST":
        date = request.form['date']
        time = request.form['time']
        person = request.form['person']
        view = request.form['view']
        with conn.cursor() as cursor:
            sql = "INSERT INTO person(`date`, `time`, `person`, `view`) VALUES (%s, %s, %s, %s)"
            data = (date,time,person,view)
            #cursor.execute(sql, (date,time,person,view))
            cursor.execute(sql,data)
            cursor.close()
        conn.commit()
        return redirect(url_for('index'))


if __name__ == '__main__':
    port = int(os.getenv('PORT', 8080))
    print("Starting app on port %d" % port)
    app.run(debug=True, port=port, host='0.0.0.0', threaded=True)
