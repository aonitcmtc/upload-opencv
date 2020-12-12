import cv2
import time
import numpy as np

model = cv2.dnn.readNetFromTensorflow('ssd_mobilenet_v2/frozen_inference_graph.pb', 'ssd_mobilenet_v2.pbtxt')
cap = cv2.VideoCapture('http://192.168.13.101:30003/videostream.cgi?rate=0&user=admin&pwd=888888')

image = cv2.imread("1.jpg")
image = cv2.resize(image,(320,240)) # resize frame for prediction

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

model.setInput(cv2.dnn.blobFromImage(image, size=(300, 300), swapRB=True))
output = model.forward()

def getClassLabel(class_id, classes):
    for key,value in classes.items():
        if class_id == key:
            return value


im_h, im_w, _ = image.shape
count = 0

for detection in output[0, 0, :, :]:
    confidence = detection[2]
    if confidence > .5:
        count = count+1
        class_id = detection[1]
        class_label = getClassLabel(class_id,COCO_labels)
        if class_id == 1.0: # 1.0 = 'person'
                x=int(detection[3]*im_w)
                y=int(detection[4]*im_h)
                w=int(detection[5]*im_w)
                h=int(detection[6]*im_h)
                cv2.rectangle(image, (x,y,w,h), (0, 255, 0), thickness=1)
                cv2.putText(image,class_label ,(x,y+25),cv2.FONT_HERSHEY_SIMPLEX,1,(255, 0, 255),1,cv2.LINE_AA)
                print(str(str(class_id) + " " + class_label + " " + str(detection[2]) + "% " ))
                print(str("Person: " + str(count)))


image = cv2.resize(image,(640,480)) # resize
cv2.imshow('image',image)
cv2.waitKey(0)
cv2.destroyAllWindows()
