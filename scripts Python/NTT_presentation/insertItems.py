import pymysql.cursors  
import pandas


data = pandas.read_csv('C:/wamp64/www/smartcityv2/scripts Python/NTT_presentation/benefitItems.csv', sep=';', engine='python', header=None)
benefits_db = pandas.read_csv('C:/wamp64/www/smartcityv2/scripts Python/NTT_presentation/benefits_db.csv', sep=';', engine='python', header=None)


def getSolution(j: int):
    return data[2][j]

def getUC(j: int):
    return data[4][j]

def getXpexType(j : int):
    return data[5][j]

def getInput(j: int):
    return [float(num.replace(' ', '').replace(',', '.').replace('%', '')) if not num == "NA#" else "NA#"  for num in data.loc[j, 6:16].to_list()]
     

def getID(j: int):
    return data.loc[0][j]

def getName(item_id: int):
    return benefits_db[1][item_id+2]

def getUnit(item_id: int):
    return str(benefits_db[10][item_id+2]).replace('nan', '')

def excel_xpex_type_to_bdd_xpex_type(xpex_type: str):
    return {"Opex":"opex",
            "Cash Releasing Benefits":"cashreleasing",
            "Capex":"capex",
            "UC Revenues (Existing)":"revenuesProtection",
            "Non quantifiable benefits":"noncash",
            "Quantifiable, non monetizable benefits":"quantifiable",
            "UC Revenues (New)":"revenues",
            "Wider Cash Benefits":"widercash"
            }[xpexType]
    


def getUcsInSolution(sol_id):
    with connection.cursor() as cursor:
        sql = "SELECT id, name  FROM use_case WHERE id_cat = %s AND id_meas = %s;"
        cursor.execute(sql, (sol_id, 25))
        res = dict()
        for row in cursor:
           res[row['name']]=row["id"]
        return res

def get_xpex_cat_id(uc_id):
    with connection.cursor() as cursor:
        sql = "SELECT id_cat, xpex_type FROM xpex_cat WHERE id_uc = %s;"
        cursor.execute(sql, (uc_id))
        res = dict()
        for row in cursor:
           res[row["xpex_type"]]=row['id_cat']
       
        return res

def getScope():
    scope = dict()
    for j in range(2, 260):
        solution = getSolution(j)
        sol_id = get_cat_id(solution)
        sub_list_UC = getUcsInSolution(sol_id)
        for UC in sub_list_UC:
            if not (solution in scope):
                scope[solution] = dict()
                scope[solution]["id"] = sol_id
                scope[solution]["set"] = dict()
          
            scope[solution]["set"][UC] = {"id" : sub_list_UC[UC],
                                          "list_xpex_cat_id": get_xpex_cat_id(sub_list_UC[UC])}
        
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


def insertXpexData(xpexType: str, inp: list, uc_id: int, id_cat: int, ucName: str, unit: str, xpex_name: str):
    with connection.cursor() as cursor:
         if(xpexType == "Cash Releasing Benefits" ):
            cursor.execute('DROP PROCEDURE IF EXISTS `add_cashreleasing`;')
            cursor.execute(""" CREATE PROCEDURE `add_cashreleasing`(
                                   IN cashreleasing_name VARCHAR(255),
                                    IN cashreleasing_desc VARCHAR(255),
                                    IN unit VARCHAR(255),
                                    IN source VARCHAR(255),
                                    IN unit_cost INT,
                                    IN min_red_nb INT,
                                    IN max_red_nb INT,
                                    IN min_red_cost INt,
                                    IN max_red_cost INT,
                                    IN idUC INT,
                                    IN cat INT,
                                    IN default_cost VARCHAR(255)
                                    )
                                    BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO cashreleasing_item (name,description,cat)
                                            VALUES (cashreleasing_name,cashreleasing_desc,cat);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO cashreleasing_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO cashreleasing_item_advice (id,unit,source,unit_cost,range_min_red_nb,range_max_red_nb,range_min_red_cost,range_max_red_cost, default_cost)
                                            VALUES (itemID,unit,source,unit_cost,min_red_nb,max_red_nb,min_red_cost,max_red_cost, default_cost);
                                    END
                                    """)
            sql = 'CALL add_cashreleasing(%s,%s,%s,%s, %s, %s,%s, %s,%s, %s,%s);'
            toUpload = (xpex_name, "", unit, "",inp[8], inp[0], inp[2], inp[3], inp[4], uc_id, id_cat)
            print(toUpload)
            cursor.execute(sql, toUpload)
            connection.commit()
         elif(xpexType == "UC Revenues (Existing)" ):
            cursor.execute('DROP PROCEDURE IF EXISTS `add_revenuesprotection`;')
            cursor.execute(""" CREATE PROCEDURE `add_revenuesprotection`(
                                    IN _name VARCHAR(255),
                                    IN _desc VARCHAR(255),
                                    IN idUC INT,
                                    IN cat INT,
                                    IN default_impact INT
                                    )
                                    BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO revenuesprotection_item (name,description,cat)
                                            VALUES (_name,_desc,cat);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO revenuesprotection_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO revenuesprotection_item_advice (id, default_impact)
                                            VALUES (itemID, default_impact);
                                    END
                                    """)
            sql = 'CALL add_revenuesprotection(%s,%s,%s,%s,%s);'
            toUpload = (xpex_name, "", uc_id, id_cat, (inp[5]+inp[4])/2)
            print(toUpload)
            cursor.execute(sql, toUpload)
            connection.commit()
         elif(xpexType == "Non quantifiable benefits" ):
            cursor.execute('DROP PROCEDURE IF EXISTS `add_noncash`;')
            cursor.execute(""" CREATE PROCEDURE `add_noncash`(
                                    IN noncash_name VARCHAR(255),
                                    IN noncash_desc VARCHAR(255),
                                    IN idUC INT,
                                    IN cat INT
                                    )
                                    BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO noncash_item (name,description,cat) 
                                                VALUES (noncash_name,noncash_desc,cat);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO noncash_uc (id_item,id_uc) VALUES (itemID,idUC);
                                    END
                                    """)
            sql = 'CALL add_noncash(%s,%s,%s,%s);'
            toUpload = (xpex_name, "", uc_id, id_cat)
            print(toUpload)
            cursor.execute(sql, toUpload)
            connection.commit()
         elif(xpexType == "Quantifiable, non monetizable benefits" ):
            cursor.execute('DROP PROCEDURE IF EXISTS `add_quantifiable`;')
            cursor.execute(""" CREATE PROCEDURE `add_quantifiable`(
                                    IN quantifiable_name VARCHAR(255),
                                    IN quantifiable_desc VARCHAR(255),
                                    IN unit VARCHAR(255),
                                    IN source VARCHAR(255),
                                    IN min_red_nb INT,
                                    IN max_red_nb INT,
                                    IN idUC INT,
                                    IN cat INT
                                    )
                                    BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO quantifiable_item (name,description,cat)
                                            VALUES (quantifiable_name,quantifiable_desc,cat);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO quantifiable_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO quantifiable_item_advice (id,unit,source,range_min_red_nb,range_max_red_nb)
                                            VALUES (itemID,unit,source,min_red_nb,max_red_nb);
                                    END
                                    """)
            sql = 'CALL add_quantifiable(%s,%s,%s,%s, %s,%s,%s,%s);'
            toUpload = (xpex_name, "", unit, "", inp[0], inp[2], uc_id, id_cat)
            print(toUpload)
            cursor.execute(sql, toUpload)
            connection.commit()
         elif(xpexType == "UC Revenues (New)" ):
            cursor.execute('DROP PROCEDURE IF EXISTS `add_revenues`;')
            cursor.execute(""" CREATE PROCEDURE `add_revenues`(
                                    IN revenues_name VARCHAR(255),
                                    IN revenues_desc VARCHAR(255),
                                    IN idUC INT,
                                    IN unit VARCHAR(255),
                                    IN source VARCHAR(255),
                                    IN range_min INT,
                                    IN range_max INT,
                                    IN cat INT,
                                    IN default_revenue VARCHAR(255)
                                    )
                                    BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO revenues_item (name,description,cat)
                                            VALUES (revenues_name,revenues_desc,cat);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO revenues_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO revenues_item_advice (id,unit,source,range_min,range_max,default_revenue)
                                            VALUES (itemID,unit,source,range_min,range_max,default_revenue);
                                    END
                                    """)
            sql = 'CALL add_revenues(%s,%s,%s,%s, %s, %s,%s, %s,%s);'
            toUpload = (xpex_name, "", uc_id, unit, "", 0, 0, id_cat, inp[9])
            print(toUpload)
            cursor.execute(sql, toUpload)
            connection.commit()
         elif(xpexType == "Wider Cash Benefits" ):
            cursor.execute('DROP PROCEDURE IF EXISTS `add_widercash`;')
            cursor.execute(""" CREATE PROCEDURE `add_widercash`(
                                    IN widercash_name VARCHAR(255),
                                    IN widercash_desc VARCHAR(255),
                                    IN unit VARCHAR(255),
                                    IN source VARCHAR(255),
                                    IN unit_cost INT,
                                    IN min_red_nb INT,
                                    IN max_red_nb INT,
                                    IN min_red_cost INt,
                                    IN max_red_cost INT,
                                    IN idUC INT,
                                    IN cat INT
                                    )
                                    BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO widercash_item (name,description,cat)
                                            VALUES (widercash_name,widercash_desc,cat);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO widercash_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO widercash_item_advice (id,unit,source,unit_cost,range_min_red_nb,range_max_red_nb,range_min_red_cost,range_max_red_cost, default_cost)
                                            VALUES (itemID,unit,source,unit_cost,min_red_nb,max_red_nb,min_red_cost,max_red_cost, default_cost);
                                    END
                                    """)
            sql = 'CALL add_widercash(%s,%s,%s,%s, %s, %s,%s, %s,%s, %s,%s);'
            toUpload = (xpex_name, "", unit, "",inp[8], inp[0], inp[2], inp[3], inp[4], uc_id, id_cat)
            print(toUpload)
            cursor.execute(sql, toUpload)
            connection.commit()
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
        uc_id = get_uc_id_from_scope(scope, sol_name, uc_name)['id']
        inp = getInput(j)
        unit = getUnit(j)
        xpex_name = getName(j)
        xpexType = getXpexType(j)
        id_cat = scope[sol_name]["set"][uc_name]['list_xpex_cat_id'][excel_xpex_type_to_bdd_xpex_type(xpexType)]
        insertXpexData(xpexType, inp, uc_id, id_cat, uc_name, unit, xpex_name)

        
        
        
    