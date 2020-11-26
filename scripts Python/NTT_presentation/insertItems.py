import pymysql.cursors  
import pandas


data = pandas.read_csv('C:/wamp64/www/smartcityv2/scripts Python/NTT_presentation/benefitItems.csv', sep=';', engine='python', header=None)


def getSolution(j):
    return data[2][j]

def getUC(j):
    return data[4][j]

def getScope():
    scope = dict()
    for j in range(2, 260):
        solution = getSolution(j)
        UC = getUC(j)
        if not (solution in scope):
            scope[solution] = dict()
            scope[solution]["id"] = get_cat_id(solution)
            scope[solution]["set"] = dict()
          
        print(scope)
        scope[solution]["set"][UC] = get_uc_id(UC)
    return scope

def get_uc_id(UC):
    with connection.cursor() as cursor:
        sql = "SELECT id FROM use_case WHERE name = %s AND id_meas = %s;"
        cursor.execute(sql, (UC, 25))
        for row in cursor:
            return row['id']
        
def get_cat_id(name):
    
    with connection.cursor() as cursor:
        sql = "SELECT id FROM use_case_cat WHERE name = %s;"
        cursor.execute(sql, (name))
        for row in cursor:
            return row['id']

if __name__ == "__main__":  
    
        
    connection = pymysql.connect(host='smartcityv2',
                                 user='root',
                                 password='',                             
                                 db='dst_v2_db_updated',
                                 charset='utf8',
                                 cursorclass=pymysql.cursors.DictCursor)
    

    print(getScope())