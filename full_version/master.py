import time
import subprocess

if __name__ == '__main__':
    #find process
    #proc = commands.getoutput('ps x | grep "java -Xmx1024m -jar proc.jar" | grep -v grep').strip()

    file_W = open('Status.txt','w')
    file_W.write('null')
    file_W.close()

    while True :
        file_R = open('Status.txt','r')
        status = file_R.read()
        print (status)

        if status == 'null' :
            deleteimg = subprocess.Popen(["find photo/ -type f -delete"],shell=True) #delete photo on /photo/...img...
            proc = subprocess.Popen(["python3","Detec_class3_php.py"],shell=False) #เสมือนเรียกไฟล์ *.py ทั่วไป
            time.sleep(5)
        else :
            file_W = open('Status.txt','w')
            file_W.write('null')
            file_W.close()

        file_R.close()
        time.sleep(150)




        
