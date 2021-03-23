import time

if __name__ == '__main__':
    num = 0
    while True:
        file = open('Status.txt','w')
        file.write('run')
        file.close()

        if num > 60 :
            break

        print ("Please,Stop me now!!!",num)
        num = num + 1

        time.sleep(.5)

