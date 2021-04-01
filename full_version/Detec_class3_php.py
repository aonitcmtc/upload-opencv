import urllib.request
import requests
import cv2
import io
import time
from time import gmtime, strftime
import numpy as np
from PIL import Image

model = cv2.dnn.readNetFromTensorflow('ssd_mobilenet_v2/frozen_inference_graph.pb', 'ssd_mobilenet_v2/ssd_mobilenet_v2.pbtxt')
cap1 = cv2.VideoCapture('http://192.168.13.111:30001/videostream.cgi?rate=0&user=admin&pwd=605232060')
cap2 = cv2.VideoCapture('http://192.168.13.112:81/videostream.cgi?rate=0&user=admin&pwd=605232060')
cap3 = cv2.VideoCapture('http://192.168.13.113:30003/videostream.cgi?rate=0&user=admin&pwd=605232060') 

#URL Control webcam
defult = 'decoder_control.cgi?loginuse=admin&loginpas=605232060&command=25&onestep=0'
up = 'decoder_control.cgi?loginuse=admin&loginpas=605232060&command=0'
down = 'decoder_control.cgi?loginuse=admin&loginpas=605232060&command=2'
left = 'decoder_control.cgi?loginuse=admin&loginpas=605232060&command=4'
right = 'decoder_control.cgi?loginuse=admin&loginpas=605232060&command=6'

#Line setup
url = 'https://notify-api.line.me/api/notify'
token = 'WeJw2Wxa33ry6nS87oucx1CkJPZokIe9D6UjgvVWTzh'
headers = {'Authorization':'Bearer '+token}


#label calss mobilenetV2
COCO_labels = { 0: 'background',
    1: 'person', 2: 'bicycle', 3: 'car', 4: 'motorcycle',
    5: 'airplane', 6: 'bus', 7: 'train', 8: 'truck', 9: 'boat',
    10: 'traffic light', 11: 'fire hydrant', 13: 'stop sign', 14: 'parking meter',
    15: 'zebra', 16: 'bird', 17: 'cat', 18: 'dog',19: 'horse',20: 'sheep',21: 'cow',22: 'elephant',
    23: 'bear', 24: 'zebra', 25: 'giraffe', 27: 'backpack', 28: 'umbrella',
    31: 'handbag', 32: 'tie', 33: 'suitcase', 34: 'frisbee', 35: 'skis',
    36: 'snowboard', 37: 'sports ball', 38: 'kite', 39: 'baseball bat', 40: 'baseball glove',
    41: 'skateboard', 42: 'surfboard', 43: 'tennis racket', 44: 'bottle', 
    46: 'wine glass', 47: 'cup', 48: 'fork', 49: 'knife', 50: 'spoon', 51: 'bowl', 52: 'banana',
    53: 'apple', 54: 'sandwich', 55: 'orange', 56: 'broccoli', 57: 'carrot', 58: 'hot dog', 59: 'pizza',
    60: 'donut', 61: 'cake', 62: 'chair', 63: 'couch', 64: 'potted plant', 65: 'bed', 
    67: 'dining table',70: 'toilet', 72: 'tv', 73: 'laptop',
    74: 'mouse', 75: 'remote', 76: 'keyboard', 78: 'microwave', 79: 'oven', 80: 'toaster', 81: 'sink',
    82: 'refrigerator',84: 'book', 85: 'clock', 86: 'vase', 87: 'scissors',
    88: 'teddy bear', 89: 'hair drier', 90: 'toothbrush' }

def getClassLabel(class_id, classes):
    for key,value in classes.items():
        if class_id == key:
            return value

def save_php_js(v1,v2,v3,v4,v5,v6,sum) :
    apiKeyValue = "tPmAT5Ab3j7F9";
    url = 'http://35.187.244.60/allview.php'
    myobj = {'api_key': apiKeyValue ,'c1v1': v1 ,'c2v1': v2 ,'c3v1': v3 , 'c1v2': v4 , 'c2v2': v5  , 'c3v2': v6 , 'sum': sum }
    x = requests.post(url, data = myobj)
    #print the response text (the content of the requested file):
    print(myobj)
    print(x.text)

def sendphotophp(num_name,name):
    path = "photo/"+num_name+name+".png"
    url='http://35.187.244.60/uploadimg.php'
    files = {'uploadfile': open(path,'rb')}
    r = requests.post(url, files = files)
    print (r.text)

def sendimg(img,msg):
    f = io.BytesIO()
    Image.fromarray(img).save(f, 'png')
    time.sleep(0.5)
    data = f.getvalue()
    r = requests.post(url, headers=headers, params={"message": msg}, files={"imageFile": data})

def process(cam,view,ps_check,line):
    if cam == 1 :
        ret, frame = cap1.read()
    elif cam == 2 :
        ret, frame = cap2.read()
    elif cam == 3 :
        ret, frame = cap3.read()
    im_h, im_w, _ = frame.shape
    psnum = 0
    model.setInput(cv2.dnn.blobFromImage(frame, size=(300, 300), swapRB=True))
    output = model.forward()
    #Draw mask point person class
    for detection in output[0, 0, :, :]:
        confidence = detection[2]
        if confidence > .36:  #def .5
           class_id = detection[1]
           class_label = getClassLabel(class_id,COCO_labels)
           if class_id == 1.0: # 1.0 = 'person'
              psnum = psnum+1
              x=int(detection[3]*im_w)
              y=int(detection[4]*im_h)
              w=int(detection[5]*im_h/2)
              h=int(detection[6]*im_w/2)
              cv2.rectangle(frame, (x,y,w,h), (160, 200, 0), thickness=1)
              #cv2.putText(frame,class_label ,(x,y+25),cv2.FONT_HERSHEY_SIMPLEX,1,(255, 0, 255),1,cv2.LINE_AA)
              cv2.putText(frame,str(psnum) ,(x,y-5),cv2.FONT_HERSHEY_PLAIN,2,(20, 255, 25),1,cv2.LINE_AA)
              #print(str(str(class_id) + " " + class_label + " " + str(detection[2]) + "% " ))
              #print(str(class_id) + " " + class_label + " " + "%.2f" %(detection[2]*100) + "% " )
              #print("Detec[1] " + str(detection[1]) + " Detec[2] " + str(detection[2]))
    msgp = "0" + str(cam) + " / " + str(view) + " Person : " + str(psnum)
    d = time.time()
    local_time = time.ctime(d)
    ps_check = psnum
    cv2.putText(frame,str("Date: " + str(local_time)) ,(20,20),cv2.FONT_HERSHEY_PLAIN,1,(10, 200, 250),1,cv2.LINE_4)
    cv2.putText(frame,str("person: " + str(psnum)) ,(20,40),cv2.FONT_HERSHEY_PLAIN,1,(10, 200, 250),1,cv2.LINE_4)
    #Save img.png
    name =  strftime("%X", gmtime())
    num_name = str(cam) + str(view) + '-'
    filename = 'photo/' + num_name + name + '.png'
    cv2.imwrite(filename, frame) 
    time.sleep(0.5)
    print(" Person " + str(psnum))
    #save_php(n_cam=cam,n_view=view,n_person=psnum)
    #sendimg(frame[:, :, ::-1],msgp)
    #print("Send Line Photo")
    #time.sleep(0.5)
    if(line == 0) : #send_line_photo
        sendimg(frame[:, :, ::-1],msgp)
        print("Send Line Photo")
    if(line == 1 or line == 3) :
        sendphotophp(num_name,name)
        print("Send Photo Database")
    return ps_check
#-------------------end process--------------------------------------

#-------------------Control Camera--------------------------------------
def Control_Camera(cam,view,step):
    if cam == 1 : 
        if view == 0:
            urllib.request.urlopen('http://192.168.13.111:30001/' + defult) # rotation Webcam
        elif view == 1: # Camera left
            for i in range(step) :
                urllib.request.urlopen('http://192.168.13.111:30001/' + left + '&onestep=1') # Camera left stop
                time.sleep(0.2)
        elif view == 2: # Camera right
            for i in range(step) :
                urllib.request.urlopen('http://192.168.13.111:30001/' + right + '&onestep=1') # Camera right stop
                time.sleep(0.2)
        elif view == 3: # Camera down
            for i in range(step) :
                urllib.request.urlopen('http://192.168.13.111:30001/' + down + '&onestep=1') # Camera right stop
                time.sleep(0.2)

    if cam == 2 : 
        if view == 0:
            urllib.request.urlopen('http://192.168.13.112:81/' + defult) # rotation Webcam
        elif view == 1: # Camera left
            for i in range(step) :
                urllib.request.urlopen('http://192.168.13.112:81/' + left + '&onestep=1') # Camera left stop
                time.sleep(0.2)
        elif view == 2: # Camera right
            for i in range(step) :
                urllib.request.urlopen('http://192.168.13.112:81/' + right + '&onestep=1') # Camera right stop
                time.sleep(0.2)
        elif view == 3: # Camera down
            for i in range(step) :
                urllib.request.urlopen('http://192.168.13.112:81/' + down + '&onestep=1') # Camera right stop
                time.sleep(0.2)

    if cam == 3 : 
        if view == 0:
            urllib.request.urlopen('http://192.168.13.113:30003/' + defult) # rotation Webcam
        elif view == 1: # Camera left
            for i in range(step) :
                urllib.request.urlopen('http://192.168.13.113:30003/' + left + '&onestep=1') # Camera left stop
                time.sleep(0.2)
        elif view == 2: # Camera right
            for i in range(step) :
                urllib.request.urlopen('http://192.168.13.113:30003/' + right + '&onestep=1') # Camera right stop
                time.sleep(0.2)
        elif view == 3: # Camera down
            for i in range(step) :
                urllib.request.urlopen('http://192.168.13.113:30003/' + down + '&onestep=1') # Camera right stop
                time.sleep(0.2)

#-------------------end Control Camera--------------------------------------

#________________ Frist Step __ Defalue Camera _____________________!!
def frist() :
    #hz60 = 'http://192.168.13.111:30001/camera_control.cgi?loginuse=admin&loginpas=605232060&param=3&value=1'
    fps30 = 'http://192.168.13.111:30001/camera_control.cgi?loginuse=admin&loginpas=605232060param=12&value=30'
    fps31 = 'http://192.168.13.112:81/camera_control.cgi?loginuse=admin&loginpas=605232060param=12&value=30'
    fps33 = 'http://192.168.13.113:30003/camera_control.cgi?loginuse=admin&loginpas=605232060param=12&value=30'
    urllib.request.urlopen(fps30)
    urllib.request.urlopen(fps31)
    urllib.request.urlopen(fps33)
    start = time.time()
    while(True) :
        t_stop = time.time()
        sec = t_stop - start
        print("Setup : " + str("%.2f" %(sec)) )
   
        if sec >= 0.0 and sec < 0.5 : Control_Camera(cam=1,view=0,step=0) #rotation = view 1
        elif sec > 0.5 and sec < 1.0 : Control_Camera(cam=2,view=0,step=0) #rotation = view 2
        elif sec > 0.1 and sec < 1.5 : Control_Camera(cam=3,view=0,step=0) #rotation = view 3
       
        elif sec > 18.0 and sec < 19.5 : Control_Camera(cam=1,view=3,step=5) # down = view 1
        elif sec > 20.0 and sec < 22.5 : Control_Camera(cam=2,view=3,step=6) # down = view 2
        #elif sec > 23.0 and sec < 24.5 : Control_Camera(cam=3,view=3,step=8) # down = view 3

        elif sec >= 30.0 : run()   
#________________ END Frist Step _______________________!!
def run() :
    #local_time = time.ctime(start)
    now = time.time()
    ps = 0
    re = 0
    s_line = 0
    c_view = [0,0,0,0,0,0]
    while(True):
        end = time.time()
        count = end - now
        #frame = cv2.resize(frame,(300,200),fx=0,fy=0, interpolation = cv2.INTER_CUBIC)
        ret, frame1 = cap1.read() #default_show_monitor
        ret, frame2 = cap2.read() #default_show_monitor
        ret, frame3 = cap3.read() #default_show_monitor

    
        if count < 8.0 :     
            ret, frame = cap1.read()
            if count >= 1.0 and count <= 1.5 : 
                file = open('Status.txt','w')
                file.write('run')
                file.close()
                #process(cam=1,view=1,ps_check=ps) #Send Photo Camera 1 view 1
                temp = process(cam=1,view=1,ps_check=ps,line=s_line)
                c_view[0] = temp
                print("count_view_person:# %d"%c_view[0]) 
            elif count >= 5.5 and count <= 6.1 : Control_Camera(cam=1,view=1,step=7) # Left

        elif count >= 8.0 and count < 16.0 :   
            ret, frame = cap2.read()
            if count >= 8.5 and count <= 9.0 :
                #process(cam=2,view=1,ps_check=ps) #Send Photo Camera 2 view 1
                temp = process(cam=2,view=1,ps_check=ps,line=s_line)
                c_view[1] = temp
                print("count_view_person:# %d"%c_view[1]) 
            elif count >= 12.5 and count <= 13.0 : Control_Camera(cam=2,view=1,step=5) # Left

        elif count >= 16.0 and count < 24.0 :    
            ret, frame = cap3.read()
            if count > 16.5 and count <= 17.0 :
                #process(cam=3,view=1,ps_check=ps) #Send Photo Camera 3 view 1
                temp = process(cam=3,view=1,ps_check=ps,line=s_line)
                c_view[2] = temp
                print("count_view_person:# %d"%c_view[2])
            #elif count >= 20.5 and count <= 21.0 : Control_Camera(cam=3,view=1,step=5) # Left

        elif count >= 26.0 and count < 30.0 :
            ret, frame = cap1.read()
            if count > 26.5 and count <= 27.0 :
                #process(cam=1,view=2,ps_check=ps) #Send Photo Camera 1 view 2
                temp = process(cam=1,view=2,ps_check=ps,line=s_line)
                c_view[3] = temp
                print("count_view_person:# %d"%c_view[3])

        elif count >= 30.0 and count < 34.0 :
            ret, frame = cap2.read()
            if count > 31.0 and count <= 31.5 :
                #process(cam=2,view=2,ps_check=ps) #Send Photo Camera 2 view 2
                temp = process(cam=2,view=2,ps_check=ps,line=s_line)
                c_view[4] = temp
                print("count_view_person:# %d"%c_view[4])

        elif count >= 34.0 and count < 38.0 :
            ret, frame = cap3.read()
            #if count > 35.0 and count <= 35.5 : 
                #process(cam=3,view=2,ps_check=ps) #Send Photo Camera 3 view 2
                #temp = process(cam=3,view=2,ps_check=ps)
                #c_view[5] = temp
                #print("count_view_person:# %d"%c_view[5])
 
        elif count > 40.0 :
            ret, frame = cap1.read()
            if count >= 42.5 and count <= 43.0 :
                print ("return1")
                Control_Camera(cam=1,view=2,step=7) # Right
            elif count >= 45.5 and count <= 46.0 : 
                print ("return2")
                Control_Camera(cam=2,view=2,step=5) # Right
            #elif count >= 49.5 and count <= 50.0 : 
                #print ("return3")
                #Control_Camera(cam=3,view=2,step=5) # Right  

        if(count > 58.0 and count < 58.5) :
            print("Save_As_Json")
            all_p = 0
            #_Test_all_count_view_
            for i in range(6) :
                all_p = all_p + c_view[i]
            #sand_data_to_php
            save_php_js(v1=c_view[0],v2=c_view[1],v3=c_view[2],v4=c_view[3],v5=c_view[4],v6=c_view[5],sum=all_p)
            ps = 0
            s_line = s_line + 1
            c_view = [0,0,0,0,0,0]
            time.sleep(0.4)
            print("All: $sum %d"%all_p)

        #if count > 60.0 and count < 61.0 : #300 = 300 ms = 5 minus
        if count > 60.0 : #300 = 300 ms = 5 minus
            now = time.time()

        #reset_send_line_photo if s_line = 0
        if(s_line >= 5) :
            re = re + 1
            s_line = 0

        #Frist_step
        if(re == 2) :
            re = 0
            time.sleep(1)
            frist()

        #All_mornitor #resize_show_monitor
        try:
            size=(426,240)
            img1 = cv2.resize(frame1,size,interpolation = cv2.INTER_AREA)
            img2 = cv2.resize(frame2,size,interpolation = cv2.INTER_AREA)
            img3 = cv2.resize(frame3,size,interpolation = cv2.INTER_AREA)
            show = np.concatenate((img1,img2,img3), axis=0)
            cv2.imshow('Monitor',show)
        except:
            file = open('Status.txt','w')
            file.write('wait')
            file.close()
            #break

        #Exit_Key_q
        key = cv2.waitKey(1) & 0xFF
        if key == ord('q'): #key exit()
            break

        print ("Sec: %d" %(count) , "line: " , s_line , "Reset: " , re)

    cap1.release()
    cap2.release()
    cap3.release()
#------------- End Run Program----------------***
#------------- Loop Project ----------------***
frist()
while(True) :
    run()
    key = cv2.waitKey(1) & 0xFF
    if key == ord('q'): #key exit()
        break
#------------- End Project ----------------***
