import time
import requests

def save_php(v1,v2,v3,v4,v5,v6,sum) :
    apiKeyValue = "tPmAT5Ab3j7F9";
    url = 'http://35.187.244.60/allview.php'
    myobj = {'api_key': apiKeyValue ,'c1v1': v1 ,'c2v1': v2 ,'c3v1': v3 , 'c1v2': v4 , 'c2v2': v5  , 'c3v2': v6 , 'sum': sum }
    x = requests.post(url, data = myobj)
    #print the response text (the content of the requested file):
    print(x.text)

def process(a,b,c):
    c = a * b
    print("Process_func: %d" %c)
    return c

one = time.time()
#onec_all_count_view
ps = 0
c_view = [0,0,0,0,0,0]
while(True):
    last = time.time()
    count = last - one
    print("Sec: %.2f"%count)
    #excample_1
    if(count > 1 and count < 2 ) :
        process(2,5,ps)
        allp = process(2,5,ps)
        ps = ps + allp
        c_view[0] = ps
        print("count_view: ***************### %d"%ps)
    elif(count > 2 and count < 3) :
        process(2,5,ps)
        allp = process(2,5,ps)
        ps = ps + allp
        c_view[1] = ps - c_view[0]
        print("count_view: ***************### %d"%ps)
    elif(count > 3 and count < 4) :
        process(2,5,ps)
        allp = process(2,5,ps)
        ps = ps + allp
        c_view[2] = ps - c_view[0] - c_view[1]
        print("count_view: ***************### %d"%ps)
    elif(count > 4 and count < 5) :
        process(2,5,ps)
        allp = process(2,5,ps)
        ps = ps + allp
        c_view[3] = ps - c_view[0] - c_view[1] - c_view[2]
        print("count_view: ***************### %d"%ps)
    elif(count > 5 and count < 6) :
        process(2,5,ps)
        allp = process(2,5,ps)
        ps = ps + allp
        c_view[4] = ps - c_view[0] - c_view[1] - c_view[2] - c_view[3]
        print("count_view: ***************### %d"%ps)
    elif(count > 6 and count < 7) :
        process(2,5,ps)
        allp = process(2,5,ps)
        ps = ps + allp
        c_view[5] = ps - c_view[0] - c_view[1] - c_view[2] - c_view[3] - c_view[4]
        print("count_view: ***************### %d"%ps)

    elif(count > 7 and count < 8) :
        all_p = 0
        #_Test_all_count_view_
        for i in range(6) :
            all_p = all_p + c_view[i]
        #sand_data_to_php
        save_php(v1=c_view[0],v2=c_view[1],v3=c_view[2],v4=c_view[3],v5=c_view[4],v6=c_view[5],sum=all_p)
        print("All: *****************@@ %d"%all_p)


    if(count > 10) :
        #all_p = 0
        ps = 0
        c_view = [0,0,0,0,0,0]
        one = time.time()

    print("All_v :" ,c_view)
    #end_Test_all_count_view
    time.sleep(1)
