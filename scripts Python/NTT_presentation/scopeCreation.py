#import pymysql.cursors  
import pandas


data = pandas.read_csv('C:/wamp64/www/smartcityv2/scripts Python/NTT_presentation/benefitItems.csv', sep=';', engine='python', header=None)


def getSolution(j):
    return data[2][j]

def getUC(j):
    return data[4][j]

for i in range(2, 26):
    print(i)