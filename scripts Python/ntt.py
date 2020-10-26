import pymysql.cursors  
import pandas


if __name__ == "__main__":  

    data = pandas.read_csv('D:/wamp64/www/smartcityv2/scripts Python/benefits.csv', sep=';', engine='python', header=None)
    connection = pymysql.connect(host='smartcityv2',
                                 user='root',
                                 password='',                             
                                 db='dst_v2_db_updated',
                                 charset='utf8',
                                 cursorclass=pymysql.cursors.DictCursor)
    
    Sol_UC = dict()
    
    for i in range(data[0].size):
        if( "#" in str(data[1][i])):
            solution = str(data[2][i])
            UC = str(data[3][i])
            if not (solution in Sol_UC.keys()):
                Sol_UC[solution] = []
            if not (UC in Sol_UC[solution]):
                Sol_UC[solution].append(UC)

    print(Sol_UC)
    connection.close()