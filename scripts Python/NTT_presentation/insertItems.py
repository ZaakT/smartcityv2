import pymysql.cursors  
import pandas


data = pandas.read_csv('C:/wamp64/www/smartcityv2/scripts Python/NTT_presentation/benefitItems.csv', sep=';', engine='python', header=None)


def getSolution(j: int):
    return data[2][j]

def getUC(j: int):
    return data[4][j]

def getXpexType(j : int):
    return data[5][j]

def getInput(j: int):
    return data.loc[j, 6:16]

def getScope():
    scope = dict()
    for j in range(2, 260):
        solution = getSolution(j)
        UC = getUC(j)
        if not (solution in scope):
            scope[solution] = dict()
            scope[solution]["id"] = get_cat_id(solution)
            scope[solution]["set"] = dict()
          
        scope[solution]["set"][UC] = get_uc_id(UC, scope[solution]["id"])
    return scope

def get_uc_id(UC: int, id_sol: int):
    with connection.cursor() as cursor:
        sql = "SELECT id FROM use_case WHERE name = %s AND id_meas = %s AND id_cat = %s;"
        cursor.execute(sql, (UC, 25, id_sol))
        for row in cursor:
            return row['id']
        
def get_cat_id(name: str):
    
    with connection.cursor() as cursor:
        sql = "SELECT id FROM use_case_cat WHERE name = %s;"
        cursor.execute(sql, (name))
        for row in cursor:
            return row['id']

def get_uc_id_from_scope(scope :dict, sol_name: str, uc_name: str):
    return scope[sol_name]["set"][uc_name]


def insertXpexData(xpexType: str, inp: list, uc_id: int):
    with connection.cursor() as cursor:
         if(xpexType == "Cash Releasing Benefits" ):
             pass
         elif(xpexType == "Cash Releasing Benefits" ):
             pass
         elif(xpexType == "UC Revenues (Existing)" ):
             pass
         elif(xpexType == "Non quantifiable benefits" ):
             pass
         elif(xpexType == "Quantifiable, non monetizable benefits" ):
             pass
         elif(xpexType == "UC Revenues (New)" ):
            cursor.execute('DROP PROCEDURE IF EXISTS `add_revenues`;')
            cursor.execute(""" CREATE PROCEDURE `add_revenues`(
                                IN revenues_name VARCHAR(255),
                                IN revenues_desc VARCHAR(255),
                                IN idUC INT,
                                IN unit VARCHAR(255),
                                IN source VARCHAR(255),
                                IN range_min INT,
                                IN range_max INT
                                )
                                BEGIN
                                    DECLARE itemID INT;
                                    INSERT INTO revenues_item (name,description)
                                        VALUES (revenues_name,revenues_desc);
                                    SET itemID = LAST_INSERT_ID();
                                    INSERT INTO revenues_uc (id_item,id_uc)
                                        VALUES (itemID,idUC);
                                    INSERT INTO revenues_item_advice (id,unit,source,range_min,range_max)
                                        VALUES (itemID,unit,source,range_min,range_max);
                                END
                                    """)
            sql = 'CALL add_revenues(%s,%s,%s,%s, %s, %s,%s);'
            toUpload = (ucName, "", ucID, unit, source, 0, 0)
            print(toUpload)
            cursor.execute(sql, toUpload)
            connection.commit()
         elif(xpexType == "Wider Cash Benefits" ):
             pass
         else:
             print(xpexType)
    
    
if __name__ == "__main__":  
    
        
    connection = pymysql.connect(host='smartcityv2',
                                 user='root',
                                 password='',                             
                                 db='dst_v2_db_updated',
                                 charset='utf8',
                                 cursorclass=pymysql.cursors.DictCursor)
    

    scope = getScope()
    
    for j in range(2, 260):
        sol_name = getSolution(j)
        uc_name = getUC(j)
        uc_id = get_uc_id_from_scope(scope, sol_name, uc_name)
        inp = getInput(j)
        xpexType = getXpexType(j)
        insertXpexData(xpexType, inp, uc_id)
        
        
        
    