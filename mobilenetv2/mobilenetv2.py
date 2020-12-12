import cv2
import time
import numpy as np

model = cv2.dnn.readNetFromTensorflow('ssd_mobilenet_v2/frozen_inference_graph.pb', 'ssd_mobilenet_v2.pbtxt')
image = cv2.VideoCapture('http://192.168.13.101:30003/videostream.cgi?rate=0&user=admin&pwd=888888')
image2 = cv2.VideoCapture('http://192.168.13.106:30002/videostream.cgi?rate=0&user=admin&pwd=888888')

#fourcc = cv2.VideoWriter_fourcc(*'DIVX')
#vdo = cv2.VideoWriter('video.avi', fourcc, 20.0, (640,480)) 
#image = cv2.resize(image,320,240) # resize frame for prediction
#(major_ver, minor_ver, subminor_ver) = (cv2.__version__).split('.')

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

#model.setInput(cv2.dnn.blobFromImage(image, size=(300, 300), swapRB=True))
#output = model.forward()

def getClassLabel(class_id, classes):
    for key,value in classes.items():
        if class_id == key:
            return value

if (image.isOpened() == False):
    print("Error reading video file")

while(True):
    # Capture frame-by-frame
    ret, frame = image.read()
    sec = time.time()
    #frame = cv2.resize(frame,(300,200),fx=0,fy=0, interpolation = cv2.INTER_CUBIC)
    im_h, im_w, _ = frame.shape
    count = 0
    key = cv2.waitKey(1) & 0xFF

    if ret == True:
        model.setInput(cv2.dnn.blobFromImage(frame, size=(300, 300), swapRB=True))
        output = model.forward()
        # file 'filename.avi' 
        #vdo.write(frame)

        for detection in output[0, 0, :, :]:
            confidence = detection[2]
            if confidence > .36:  #def .5
                class_id = detection[1]
                class_label = getClassLabel(class_id,COCO_labels)
                if class_id == 1.0: # 1.0 = 'person'
                    count = count+1
                    x=int(detection[3]*im_w)
                    y=int(detection[4]*im_h)
                    w=int(detection[5]*im_h/2)
                    h=int(detection[6]*im_w/2)
                    cv2.rectangle(frame, (x,y,w,h), (255, 0, 255), thickness=1)
                    #cv2.putText(frame,class_label ,(x,y+25),cv2.FONT_HERSHEY_SIMPLEX,1,(255, 0, 255),1,cv2.LINE_AA)
                    cv2.putText(frame,str(count) ,(x,y-5),cv2.FONT_HERSHEY_PLAIN,3,(0, 255, 0),2,cv2.LINE_AA)
                    #print(str(str(class_id) + " " + class_label + " " + str(detection[2]) + "% " ))
                    print(str(str(class_id) + " " + class_label + " " + str(detection[2]) + "% " ))
                    #print("Detec[1] " + str(detection[1]) + " Detec[2] " + str(detection[2]))

    cv2.putText(frame,str("person: " + str(count)) ,(20,20),cv2.FONT_HERSHEY_PLAIN,1,(120, 150, 250),1,cv2.LINE_AA)

    if key == ord('q'): #key exit()
        break

    cv2.imshow('monitor',frame)

    end = time.time()
    print(str("Person: " + str(count) + str(frame.shape) + " FPS: " + str(1.0/(end-sec)) ))
image.release()
cv2.destroyAllWindows()
