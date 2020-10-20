
# -*- coding: utf-8 -*-
"""
Created on Tue Oct 20 12:35:22 2020

@author: Diego
"""
import pymysql.cursors  
import pandas
 
# Connectez- vous à la base de données.







xpexTable = ["capex", "implem", "opex", "revenues", "cashreleasing", "widercash", "", "risk"]
UCTable=[i for i in  range(12, 28)]




data = pandas.read_csv('D:/wamp64/www/smartcityv2/UserGuide/Montreal.csv', sep=';', engine='python', header=None)



def uploadData(valueList, ucID, xpexType):
    projID = 27
    if(xpexType!="" and valueList[0]!='0' and valueList[0]!='0%'):
        with connection.cursor() as cursor:
            if(xpexType=="capex"):
                cursor.execute('DROP PROCEDURE IF EXISTS `add_capex`;')
                cursor.execute(""" CREATE PROCEDURE `add_capex`(
                                    IN capex_name VARCHAR(255),
                                    IN capex_desc VARCHAR(255),
                                    IN idUC INT,
                                    IN unit VARCHAR(255),
                                    IN source VARCHAR(255),
                                    IN range_min INT,
                                    IN range_max INT
                                    )
                                    BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO capex_item (name,description)
                                            VALUES (capex_name,capex_desc);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO capex_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO capex_item_advice (id,unit,source,range_min,range_max)
                                            VALUES (itemID,unit,source,range_min,range_max);
                                    END
                                        """)
                sql = 'CALL add_capex(%s,%s,%s,%s, %s, %s,%s);'
                # print((type(valueList[0]),type( valueList[1]), type(ucID), type(valueList[2]), type(valueList[6]), type(valueList[4]), type(valueList[5])))
                cursor.execute(sql, (valueList[0], valueList[1], ucID, valueList[2], valueList[6], valueList[4], valueList[5]))
            
                
            
            
            if(xpexType=="implem"):
                cursor.execute('DROP PROCEDURE IF EXISTS `add_implem`;')
                cursor.execute(""" CREATE PROCEDURE `add_implem`(
                                    IN implem_name VARCHAR(255),
                                    IN implem_desc VARCHAR(255),
                                    IN idUC INT,
                                    IN unit VARCHAR(255),
                                    IN source VARCHAR(255),
                                    IN range_min INT,
                                    IN range_max INT
                                    )
                                    BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO implem_item (name,description)
                                            VALUES (implem_name,implem_desc);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO implem_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO implem_item_advice (id,unit,source,range_min,range_max)
                                            VALUES (itemID,unit,source,range_min,range_max);
                                    END
                                        """)
                sql = 'CALL add_implem(%s,%s,%s,%s, %s, %s,%s);'
                # print((type(valueList[0]),type( valueList[1]), type(ucID), type(valueList[2]), type(valueList[6]), type(valueList[4]), type(valueList[5])))
                cursor.execute(sql, (valueList[0], "", ucID, valueList[1], valueList[5], valueList[3], valueList[4]))
            if(xpexType=="opex"):
                cursor.execute('DROP PROCEDURE IF EXISTS `add_opex`;')
                cursor.execute(""" CREATE PROCEDURE `add_opex`(
                                    IN opex_name VARCHAR(255),
                                    IN opex_desc VARCHAR(255),
                                    IN idUC INT,
                                    IN unit VARCHAR(255),
                                    IN source VARCHAR(255),
                                    IN range_min INT,
                                    IN range_max INT
                                    )
                                    BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO opex_item (name,description)
                                            VALUES (opex_name,opex_desc);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO opex_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO opex_item_advice (id,unit,source,range_min,range_max)
                                            VALUES (itemID,unit,source,range_min,range_max);
                                    END
                                        """)
                sql = 'CALL add_opex(%s,%s,%s,%s, %s, %s,%s);'
                toUpload = (valueList[0], "", ucID, valueList[1], valueList[5], valueList[3], valueList[4])
                print(toUpload)
                cursor.execute(sql, toUpload)
                
            if(xpexType=="revenues"):
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
                toUpload = (valueList[0], "", ucID, valueList[1], valueList[5], valueList[3], valueList[4])
                print(toUpload)
                cursor.execute(sql, toUpload)
            if(xpexType=="cashreleasing"):
                cursor.execute('DROP PROCEDURE IF EXISTS `add_cashreleasing`;')
                cursor.execute("""  CREATE PROCEDURE `add_cashreleasing`(
                                    IN cashreleasing_name VARCHAR(255),
                                    IN cashreleasing_desc VARCHAR(255),
                                    IN unit VARCHAR(255),
                                    IN source VARCHAR(255),
                                    IN unit_cost INT,
                                    IN min_red_nb INT,
                                    IN max_red_nb INT,
                                    IN min_red_cost INt,
                                    IN max_red_cost INT,
                                    IN idUC INT
                                    )
                                    BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO cashreleasing_item (name,description)
                                            VALUES (cashreleasing_name,cashreleasing_desc);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO cashreleasing_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO cashreleasing_item_advice (id,unit,source,unit_cost,range_min_red_nb,range_max_red_nb,range_min_red_cost,range_max_red_cost)
                                            VALUES (itemID,unit,source,unit_cost,min_red_nb,max_red_nb,min_red_cost,max_red_cost);
                                    END
                                        """)
                sql = 'CALL add_cashreleasing(%s,%s,%s,%s, %s, %s,%s, %s,%s, %s);'
                toUpload = (valueList[0], "", valueList[1], valueList[8], valueList[3], valueList[4], valueList[5], valueList[6], valueList[7], ucID)
                print(toUpload)
                cursor.execute(sql, toUpload)
            if(xpexType=="widercash"):
                cursor.execute('DROP PROCEDURE IF EXISTS `add_widercash`;')
                cursor.execute("""  CREATE PROCEDURE `add_widercash`(
                                    IN widercash_name VARCHAR(255),
                                    IN widercash_desc VARCHAR(255),
                                    IN unit VARCHAR(255),
                                    IN source VARCHAR(255),
                                    IN unit_cost INT,
                                    IN min_red_nb INT,
                                    IN max_red_nb INT,
                                    IN min_red_cost INt,
                                    IN max_red_cost INT,
                                    IN idUC INT
                                    )
                                    BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO widercash_item (name,description)
                                            VALUES (widercash_name,widercash_desc);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO widercash_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO widercash_item_advice (id,unit,source,unit_cost,range_min_red_nb,range_max_red_nb,range_min_red_cost,range_max_red_cost)
                                            VALUES (itemID,unit,source,unit_cost,min_red_nb,max_red_nb,min_red_cost,max_red_cost);
                                    END
                                        """)
                sql = 'CALL add_widercash(%s,%s,%s,%s, %s, %s,%s, %s,%s, %s);'
                toUpload = (valueList[0], "", valueList[1], valueList[8], valueList[3], valueList[4], valueList[5], valueList[6], valueList[7], ucID)
                print(toUpload)
                cursor.execute(sql, toUpload)
            if(xpexType=="risk"):
                cursor.execute('DROP PROCEDURE IF EXISTS `add_risks`;')
                cursor.execute("""  CREATE PROCEDURE `add_risks`(
                                    IN risks_name VARCHAR(255),
                                    IN risks_desc VARCHAR(255),
                                    IN idUC INT
                                    )
                                    BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO risk_item (name,description) 
                                                VALUES (risks_name,risks_desc);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO risk_uc (id_item,id_uc) VALUES (itemID,idUC);
                                    END
                                
                                        """)
                sql = 'CALL add_risks(%s,%s,%s);'
                toUpload = (valueList[0], "", ucID)
                print(toUpload)
                cursor.execute(sql, toUpload)


def getXpexTypeName(x):
    xpexTable = ["capex", "implem", "opex", "revenues", "cashreleasing", "widercash", "", "risk"]
    return xpexTable[int(data.at[x, 1].split(".")[0])-1]

def getUcID(col):
    return int(data.at[1, col].split('.')[0])+11

def getItemNb(line):
    return int(data.at[line, 3].split(" ")[1])

if __name__ == "__main__":  

    connection = pymysql.connect(host='smartcityv2',
                                 user='root',
                                 password='',                             
                                 db='dst_v2_db_updated',
                                 charset='utf8',
                                 cursorclass=pymysql.cursors.DictCursor)
    for col in range(5, 24):
        ucID = str(getUcID(col))
        line = 2
        value = data.at[line, col]
        itemNB = getItemNb(line)
        valueList=[data.at[line, col]]
        while(value and line<500):        
            line+=1
            print(line)
            if(line<437):
                if(itemNB != getItemNb(line)):
                    uploadData(valueList, ucID, getXpexTypeName(line))
                    valueList=[]
                    
                
                
                value = data.at[line, col]
                itemNB = getItemNb(line)
                value = data.at[line, col]
                valueList.append(value )



connection.close()