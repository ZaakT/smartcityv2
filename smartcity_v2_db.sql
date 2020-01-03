CREATE TABLE critCat (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE,
    PRIMARY KEY (id)
);

CREATE TABLE crit(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL UNIQUE,
   description TEXT DEFAULT NULL,
   scoring_guidance TEXT,
   id_cat INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_cat) REFERENCES critCat(id) ON DELETE CASCADE
);

CREATE TABLE use_case_cat(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL UNIQUE,
   description TEXT DEFAULT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE dlt(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL UNIQUE,
   description TEXT DEFAULT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE project_group(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   description VARCHAR(255),
   size INT,
   PRIMARY KEY(id)
);

CREATE TABLE measure(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL UNIQUE,
   description TEXT DEFAULT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE invest_capacity(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   description VARCHAR(255),
   PRIMARY KEY(id)
);

CREATE TABLE business_model_pref(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   description VARCHAR(255),
   PRIMARY KEY(id)
);

CREATE TABLE payback_constraints(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   description VARCHAR(255),
   PRIMARY KEY(id)
);

CREATE TABLE funding_sources_category(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   description TEXT DEFAULT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE funding_source(
   id INT NOT NULL AUTO_INCREMENT,
   id_type INT NOT NULL DEFAULT 1,
   name VARCHAR(255) NOT NULL,
   description TEXT DEFAULT NULL,
   id_cat INT NOT NULL,
   hasEntities tinyint(4) DEFAULT 1,
   PRIMARY KEY(id),
   FOREIGN KEY(id_cat) REFERENCES funding_sources_category(id) ON DELETE CASCADE,
   FOREIGN KEY(id_type) REFERENCES funding_sources_category(id) ON DELETE CASCADE
);

CREATE TABLE user(
   id INT NOT NULL AUTO_INCREMENT,
   username VARCHAR(255) NOT NULL UNIQUE,
   lastname VARCHAR(255) DEFAULT NULL,
   firstname VARCHAR(255) DEFAULT NULL,
   email VARCHAR(255) UNIQUE,
   password VARCHAR(255) NOT NULL,
   salt VARCHAR(255) NOT NULL,
   is_admin BOOLEAN,
   is_active BOOLEAN,
   creation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY(id)
);

CREATE TABLE role(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL UNIQUE,
   PRIMARY KEY(id)
);

CREATE TABLE magnitude(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL UNIQUE,
   range_min REAL,
   range_max REAL,
   PRIMARY KEY(id)
);

CREATE TABLE project(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   description TEXT DEFAULT NULL,
   discount_rate REAL,
   weight_bank REAL,
   weight_bank_soc REAL,
   creation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
   modif_date DATETIME ON UPDATE CURRENT_TIMESTAMP,
   id_user INT NOT NULL,
   scoping TINYINT NULL DEFAULT 0,
   cb TINYINT NULL DEFAULT 0,
   PRIMARY KEY(id),
   FOREIGN KEY(id_user) REFERENCES user(id) ON DELETE CASCADE
);

CREATE TABLE use_case(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL UNIQUE,
   description TEXT DEFAULT NULL,
   id_meas INT NOT NULL,
   id_cat INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_meas) REFERENCES measure(id) ON DELETE CASCADE,
   FOREIGN KEY(id_cat) REFERENCES use_case_cat(id) ON DELETE CASCADE
);

CREATE TABLE component(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   id_meas INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_meas) REFERENCES measure(id) ON DELETE CASCADE
);

CREATE TABLE capex_item(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   description TEXT DEFAULT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE cashreleasing_item(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   description TEXT DEFAULT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE widercash_item(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   description TEXT DEFAULT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE noncash_item(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   description TEXT DEFAULT NULL,
   sources TEXT,
   PRIMARY KEY(id)
);

CREATE TABLE risk_item(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   description TEXT DEFAULT NULL,
   sources TEXT,
   PRIMARY KEY(id)
);

CREATE TABLE capex_item_advice(
   id INT NOT NULL AUTO_INCREMENT,
   unit VARCHAR(255),
   source TEXT,
   range_min INT,
   range_max INT,
   PRIMARY KEY(id),
   FOREIGN KEY(id) REFERENCES capex_item(id) ON DELETE CASCADE
);

CREATE TABLE capex_item_user(
   id INT NOT NULL AUTO_INCREMENT,
   id_proj INT,
   PRIMARY KEY(id),
   FOREIGN KEY(id) REFERENCES capex_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE
);

CREATE TABLE implem_item(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   description TEXT DEFAULT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE implem_item_advice(
   id INT NOT NULL AUTO_INCREMENT,
   unit VARCHAR(255),
   source TEXT,
   range_min INT,
   range_max INT,
   PRIMARY KEY(id),
   FOREIGN KEY(id) REFERENCES implem_item(id) ON DELETE CASCADE
);

CREATE TABLE implem_item_user(
   id INT NOT NULL AUTO_INCREMENT,
   id_proj INT,
   PRIMARY KEY(id),
   FOREIGN KEY(id) REFERENCES implem_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE
);

CREATE TABLE opex_item(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   description TEXT DEFAULT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE opex_item_advice(
   id INT NOT NULL AUTO_INCREMENT,
   unit VARCHAR(255),
   source TEXT,
   range_min DOUBLE,
   range_max DOUBLE,
   PRIMARY KEY(id),
   FOREIGN KEY(id) REFERENCES opex_item(id) ON DELETE CASCADE
);

CREATE TABLE opex_item_user(
   id INT NOT NULL AUTO_INCREMENT,
   id_proj INT,
   PRIMARY KEY(id),
   FOREIGN KEY(id) REFERENCES opex_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE
);

CREATE TABLE revenues_item(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   description TEXT DEFAULT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE revenues_item_advice(
   id INT NOT NULL AUTO_INCREMENT,
   unit VARCHAR(255),
   source TEXT,
   range_min DOUBLE,
   range_max DOUBLE,
   PRIMARY KEY(id),
   FOREIGN KEY(id) REFERENCES revenues_item(id) ON DELETE CASCADE
);

CREATE TABLE revenues_item_user(
   id INT NOT NULL AUTO_INCREMENT,
   id_proj INT,
   PRIMARY KEY(id),
   FOREIGN KEY(id) REFERENCES revenues_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE
);

CREATE TABLE cashreleasing_item_advice(
   id INT NOT NULL AUTO_INCREMENT,
   unit VARCHAR(255),
   source TEXT,
   unit_cost DOUBLE,
   range_min_red_nb DOUBLE,
   range_max_red_nb DOUBLE,
   range_min_red_cost DOUBLE,
   range_max_red_cost DOUBLE,
   PRIMARY KEY(id),
   FOREIGN KEY(id) REFERENCES cashreleasing_item(id) ON DELETE CASCADE
);

CREATE TABLE cashreleasing_item_user(
   id INT NOT NULL AUTO_INCREMENT,
   id_proj INT,
   PRIMARY KEY(id),
   FOREIGN KEY(id) REFERENCES cashreleasing_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE
);

CREATE TABLE widercash_item_advice(
   id INT NOT NULL AUTO_INCREMENT,
   unit VARCHAR(255),
   source TEXT,
   unit_cost DOUBLE,
   range_min_red_nb DOUBLE,
   range_max_red_nb DOUBLE,
   range_min_red_cost DOUBLE,
   range_max_red_cost DOUBLE,
   PRIMARY KEY(id),
   FOREIGN KEY(id) REFERENCES widercash_item(id) ON DELETE CASCADE
);

CREATE TABLE widercash_item_user(
   id INT NOT NULL AUTO_INCREMENT,
   id_proj INT,
   PRIMARY KEY(id),
   FOREIGN KEY(id) REFERENCES widercash_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE
);

CREATE TABLE noncash_item_advice(
   id INT NOT NULL AUTO_INCREMENT,
   PRIMARY KEY(id),
   FOREIGN KEY(id) REFERENCES noncash_item(id) ON DELETE CASCADE
);

CREATE TABLE noncash_item_user(
   id INT NOT NULL AUTO_INCREMENT,
   id_proj INT,
   PRIMARY KEY(id),
   FOREIGN KEY(id) REFERENCES noncash_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE
);

CREATE TABLE risk_item_advice(
   id INT NOT NULL AUTO_INCREMENT,
   PRIMARY KEY(id),
   FOREIGN KEY(id) REFERENCES risk_item(id) ON DELETE CASCADE
);

CREATE TABLE risk_item_user(
   id INT NOT NULL AUTO_INCREMENT,
   id_proj INT,
   PRIMARY KEY(id),
   FOREIGN KEY(id) REFERENCES risk_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE
);

CREATE TABLE use_cases_menu(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   description TEXT DEFAULT NULL,
   creation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
   modif_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   id_user INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_user) REFERENCES user(id) ON DELETE CASCADE
);


CREATE TABLE zone(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   type VARCHAR(255),
   id_zone INT,
   PRIMARY KEY(id),
   FOREIGN KEY(id_zone) REFERENCES zone(id) ON DELETE CASCADE
);

CREATE TABLE project_perimeter(
   id_proj INT NOT NULL,
   id_zone INT,
   PRIMARY KEY(id_proj,id_zone),
   FOREIGN KEY(id_zone) REFERENCES zone(id) ON DELETE CASCADE,
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE

);

CREATE TABLE financing_scenario(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   description TEXT DEFAULT NULL,
   input_invest DOUBLE DEFAULT -1,
   input_op DOUBLE DEFAULT -1,
   creation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
   modif_date DATETIME ON UPDATE CURRENT_TIMESTAMP,
   id_proj INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE
);

CREATE TABLE beneficiary(
   id INT NOT NULL AUTO_INCREMENT,
   id_finScen INT NOT NULL,
   name VARCHAR(255) NOT NULL,
   description TEXT DEFAULT NULL,
   share REAL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_finScen) REFERENCES financing_scenario(id) ON DELETE CASCADE
);


CREATE TABLE entity(
   id INT NOT NULL AUTO_INCREMENT,
   id_source INT NOT NULL,
   id_finScen INT NOT NULL,
   name VARCHAR(255) NOT NULL,
   description TEXT DEFAULT NULL,
   start_date DATE,
   share REAL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_source) REFERENCES funding_source(id) ON DELETE CASCADE,
   FOREIGN KEY(id_finScen) REFERENCES financing_scenario(id) ON DELETE CASCADE
);

CREATE TABLE loans_and_bonds(
   id INT NOT NULL AUTO_INCREMENT,
   maturity_date DATE,
   interest REAL,
   PRIMARY KEY(id),
   FOREIGN KEY(id) REFERENCES entity(id) ON DELETE CASCADE
);

CREATE TABLE others(
   id INT NOT NULL AUTO_INCREMENT,
   PRIMARY KEY(id),
   FOREIGN KEY(id) REFERENCES entity(id) ON DELETE CASCADE
);

CREATE TABLE funding_sources_type(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   description TEXT DEFAULT NULL,
   PRIMARY KEY(id)
);

/* CREATE TABLE sel_entity(
   id_source INT NOT NULL,
   id_finScen INT NOT NULL,
   id_entity INT NOT NULL,
   PRIMARY KEY(id_source,id_finScen,id_entity),
   FOREIGN KEY(id_source) REFERENCES funding_source(id) ON DELETE CASCADE,
   FOREIGN KEY(id_finScen) REFERENCES financing_scenario(id) ON DELETE CASCADE,
   FOREIGN KEY(id_entity) REFERENCES entity(id) ON DELETE CASCADE
); */

CREATE TABLE ucm_sel_crit(
   id_crit INT,
   id_ucm INT,
   PRIMARY KEY(id_crit, id_ucm),
   FOREIGN KEY(id_crit) REFERENCES crit(id) ON DELETE CASCADE,
   FOREIGN KEY(id_ucm) REFERENCES use_cases_menu(id) ON DELETE CASCADE
);

CREATE TABLE uc_vs_crit_input(
   id_uc INT,
   id_crit INT,
   id_ucm INT,
   rate INT,
   PRIMARY KEY(id_uc, id_crit, id_ucm),
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE,
   FOREIGN KEY(id_crit) REFERENCES crit(id) ON DELETE CASCADE,
   FOREIGN KEY(id_ucm) REFERENCES use_cases_menu(id) ON DELETE CASCADE
);

CREATE TABLE uc_vs_crit(
   id_uc INT,
   id_crit INT,
   pertinence INT,
   range_min INT,
   range_max INT,
   PRIMARY KEY(id_uc, id_crit),
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE,
   FOREIGN KEY(id_crit) REFERENCES crit(id) ON DELETE CASCADE
);

CREATE TABLE ucm_sel_dlt(
   id_ucm INT,
   id_dlt INT,
   PRIMARY KEY(id_ucm, id_dlt),
   FOREIGN KEY(id_ucm) REFERENCES use_cases_menu(id) ON DELETE CASCADE,
   FOREIGN KEY(id_dlt) REFERENCES dlt(id) ON DELETE CASCADE
);

CREATE TABLE uc_vs_dlt(
   id_uc INT,
   id_dlt INT,
   pertinence INT,
   PRIMARY KEY(id_uc, id_dlt),
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE,
   FOREIGN KEY(id_dlt) REFERENCES dlt(id) ON DELETE CASCADE
);

CREATE TABLE ucm_sel_uc(
   id_uc INT,
   id_ucm INT,
   PRIMARY KEY(id_uc, id_ucm),
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE,
   FOREIGN KEY(id_ucm) REFERENCES use_cases_menu(id) ON DELETE CASCADE
);

CREATE TABLE ucm_sel_critcat(
   id_critCat INT,
   id_ucm INT,
   weight REAL,
   PRIMARY KEY(id_critCat, id_ucm),
   FOREIGN KEY(id_critCat) REFERENCES critCat(id) ON DELETE CASCADE,
   FOREIGN KEY(id_ucm) REFERENCES use_cases_menu(id) ON DELETE CASCADE
);

CREATE TABLE proj_sel_measure(
   id_proj INT,
   id_meas INT,
   PRIMARY KEY(id_proj, id_meas),
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE,
   FOREIGN KEY(id_meas) REFERENCES measure(id) ON DELETE CASCADE
);

CREATE TABLE proj_sel_usecase(
   id_uc INT,
   id_proj INT,
   PRIMARY KEY(id_uc, id_proj),
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE,
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE
);

CREATE TABLE shared_ucm(
   id_user INT,
   id_ucm INT,
   id_group INT,
   PRIMARY KEY(id_user, id_ucm, id_group),
   FOREIGN KEY(id_user) REFERENCES user(id) ON DELETE CASCADE,
   FOREIGN KEY(id_ucm) REFERENCES use_cases_menu(id) ON DELETE CASCADE,
   FOREIGN KEY(id_group) REFERENCES project_group(id) ON DELETE CASCADE
);

CREATE TABLE shared_project(
   id_user INT,
   id_proj INT,
   id_group INT,
   PRIMARY KEY(id_user, id_proj, id_group),
   FOREIGN KEY(id_user) REFERENCES user(id) ON DELETE CASCADE,
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE,
   FOREIGN KEY(id_group) REFERENCES project_group(id) ON DELETE CASCADE
);

CREATE TABLE project_size(
   id_uc INT,
   id_zone INT,
   id_mag INT,
   id_proj INT,
   PRIMARY KEY(id_uc, id_zone, id_mag, id_proj),
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE,
   FOREIGN KEY(id_zone) REFERENCES zone(id) ON DELETE CASCADE,
   FOREIGN KEY(id_mag) REFERENCES magnitude(id) ON DELETE CASCADE,
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE
);

CREATE TABLE volumes_input(
   id_uc INT,
   id_zone INT,
   id_proj INT,
   nb_compo INT DEFAULT NULL,
   nb_per_uc INT DEFAULT NULL,
   PRIMARY KEY(id_uc, id_zone, id_proj),
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE,
   FOREIGN KEY(id_zone) REFERENCES zone(id) ON DELETE CASCADE,
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE
);

CREATE TABLE input_implem(
   id_proj INT,
   id_item INT,
   id_uc INT,
   volume INT,
   unit_cost DOUBLE,
   PRIMARY KEY(id_proj, id_item, id_uc),
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE,
   FOREIGN KEY(id_item) REFERENCES implem_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE
);

CREATE TABLE input_capex(
   id_item INT,
   id_proj INT,
   id_uc INT,
   volume INT,
   unit_cost DOUBLE,
   period INT,
   PRIMARY KEY(id_item, id_proj,id_uc),
   FOREIGN KEY(id_item) REFERENCES capex_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE,
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE
);

CREATE TABLE ratio_comp_per_uc(
   id_uc INT,
   id_compo INT,
   val DOUBLE,
   PRIMARY KEY(id_uc, id_compo),
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE,
   FOREIGN KEY(id_compo) REFERENCES component(id) ON DELETE CASCADE
);

CREATE TABLE input_opex(
   id_proj INT,
   id_item INT,
   id_uc INT,
   volume INT,
   unit_cost DOUBLE,
   annual_variation_volume REAL,
   annual_variation_unitcost REAL,
   PRIMARY KEY(id_proj, id_item,id_uc),
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE,
   FOREIGN KEY(id_item) REFERENCES opex_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE
);

CREATE TABLE input_revenues(
   id_proj INT,
   id_item INT,
   id_uc INT,
   volume INT,
   revenues_per_unit DOUBLE,
   annual_variation_volume REAL,
   annual_variation_unitcost REAL,
   PRIMARY KEY(id_proj, id_item,id_uc),
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE,
   FOREIGN KEY(id_item) REFERENCES revenues_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE
);

CREATE TABLE ratio_comp_capex(
   id_compo INT,
   id_item INT,
   val DOUBLE,
   PRIMARY KEY(id_compo, id_item),
   FOREIGN KEY(id_compo) REFERENCES component(id) ON DELETE CASCADE,
   FOREIGN KEY(id_item) REFERENCES capex_item_advice(id) ON DELETE CASCADE
);

CREATE TABLE ratio_comp_implem(
   id_compo INT,
   id_item INT,
   val DOUBLE,
   PRIMARY KEY(id_compo, id_item),
   FOREIGN KEY(id_compo) REFERENCES component(id) ON DELETE CASCADE,
   FOREIGN KEY(id_item) REFERENCES implem_item_advice(id) ON DELETE CASCADE
);

CREATE TABLE ratio_comp_opex(
   id_compo INT,
   id_item INT,
   val DOUBLE,
   PRIMARY KEY(id_compo, id_item),
   FOREIGN KEY(id_compo) REFERENCES component(id) ON DELETE CASCADE,
   FOREIGN KEY(id_item) REFERENCES opex_item_advice(id) ON DELETE CASCADE
);

CREATE TABLE ratio_comp_revenues(
   id_compo INT,
   id_item INT,
   val DOUBLE,
   PRIMARY KEY(id_compo, id_item),
   FOREIGN KEY(id_compo) REFERENCES component(id) ON DELETE CASCADE,
   FOREIGN KEY(id_item) REFERENCES revenues_item_advice(id) ON DELETE CASCADE
);

CREATE TABLE ratio_comp_cashreleasing(
   id_compo INT,
   id_item INT,
   val DOUBLE,
   PRIMARY KEY(id_compo, id_item),
   FOREIGN KEY(id_compo) REFERENCES component(id) ON DELETE CASCADE,
   FOREIGN KEY(id_item) REFERENCES cashreleasing_item_advice(id) ON DELETE CASCADE
);

CREATE TABLE ratio_comp_widercash(
   id_compo INT,
   id_item INT,
   val DOUBLE,
   PRIMARY KEY(id_compo, id_item),
   FOREIGN KEY(id_compo) REFERENCES component(id) ON DELETE CASCADE,
   FOREIGN KEY(id_item) REFERENCES widercash_item_advice(id) ON DELETE CASCADE
);

CREATE TABLE input_cashreleasing(
   id_item INT,
   id_proj INT,
   id_uc INT,
   unit_indicator VARCHAR(255),
   volume INT,
   unit_cost DOUBLE,
   volume_reduc REAL,
   unit_cost_reduc REAL,
   annual_var_volume REAL,
   annual_var_unit_cost REAL,
   PRIMARY KEY(id_item, id_proj,id_uc),
   FOREIGN KEY(id_item) REFERENCES cashreleasing_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE,
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE
);

CREATE TABLE implem_schedule(
   id_uc INT,
   id_proj INT,
   start_date DATE,
   25_completion DATE,
   50_completion DATE,
   75_completion DATE,
   100_completion DATE,
   PRIMARY KEY(id_uc, id_proj),
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE,
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE
);

CREATE TABLE revenue_schedule(
   id_uc INT,
   id_proj INT,
   start_date DATE,
   25_rampup DATE,
   50_rampup DATE,
   75_rampup DATE,
   100_rampup DATE,
   end_date DATE,
   PRIMARY KEY(id_uc, id_proj),
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE,
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE
);

CREATE TABLE opex_schedule(
   id_uc INT,
   id_proj INT,
   start_date DATE,
   25_rampup DATE,
   50_rampup DATE,
   75_rampup DATE,
   100_rampup DATE,
   end_date DATE,
   PRIMARY KEY(id_uc, id_proj),
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE,
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE
);

CREATE TABLE input_widercash(
   id_item INT,
   id_proj INT,
   id_uc INT,
   unit_indicator VARCHAR(255),
   volume INT,
   unit_cost DOUBLE,
   volume_reduc REAL,
   unit_cost_reduc REAL,
   annual_var_volume REAL,
   annual_var_unit_cost REAL,
   PRIMARY KEY(id_item, id_proj, id_uc),
   FOREIGN KEY(id_item) REFERENCES widercash_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE,
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE
);

CREATE TABLE input_noncash(
   id_item INT,
   id_proj INT,
   id_uc INT,
   expected_impact INT,
   probability REAL,
   PRIMARY KEY(id_item, id_proj, id_uc),
   FOREIGN KEY(id_item) REFERENCES noncash_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE,
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE
);

CREATE TABLE input_risk(
   id_item INT,
   id_proj INT,
   id_uc INT,
   expected_impact INT,
   probability REAL,
   PRIMARY KEY(id_item, id_proj,id_uc),
   FOREIGN KEY(id_item) REFERENCES risk_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE,
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE
);

CREATE TABLE comp_per_zone(
   id_zone INT,
   id_compo INT,
   number INT,
   PRIMARY KEY(id_zone, id_compo),
   FOREIGN KEY(id_zone) REFERENCES zone(id) ON DELETE CASCADE,
   FOREIGN KEY(id_compo) REFERENCES component(id) ON DELETE CASCADE
);

CREATE TABLE volumes(
   id_uc INT,
   id_zone INT,
   name VARCHAR(255) NOT NULL,
   val INT,
   PRIMARY KEY(id_uc, id_zone),
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE,
   FOREIGN KEY(id_zone) REFERENCES zone(id) ON DELETE CASCADE
);

CREATE TABLE business_model(
   id_investcap INT,
   id_payconst INT,
   id_bmpref INT,
   id_proj INT,
   PRIMARY KEY(id_proj),
   FOREIGN KEY(id_investcap) REFERENCES invest_capacity(id) ON DELETE CASCADE,
   FOREIGN KEY(id_bmpref) REFERENCES business_model_pref(id) ON DELETE CASCADE,
   FOREIGN KEY(id_payconst) REFERENCES payback_constraints(id) ON DELETE CASCADE,
   FOREIGN KEY(id_proj) REFERENCES project(id) ON DELETE CASCADE
);

CREATE TABLE sel_funding_source(
   id_finScen INT,
   id_source INT,
   share REAL DEFAULT 0,
   interest REAL DEFAULT 0,
   start_date DATE DEFAULT null,
   maturity_date DATE DEFAULT null,
   PRIMARY KEY(id_finScen, id_source),
   FOREIGN KEY(id_finScen) REFERENCES financing_scenario(id) ON DELETE CASCADE,
   FOREIGN KEY(id_source) REFERENCES funding_source(id) ON DELETE CASCADE
);

CREATE TABLE user_zone(
   id_zone INT,
   id_user INT,
   PRIMARY KEY(id_zone, id_user),
   FOREIGN KEY(id_zone) REFERENCES zone(id) ON DELETE CASCADE,
   FOREIGN KEY(id_user) REFERENCES user(id) ON DELETE CASCADE
);

CREATE TABLE user_measure(
   id_meas INT,
   id_user INT,
   PRIMARY KEY(id_meas, id_user),
   FOREIGN KEY(id_meas) REFERENCES measure(id) ON DELETE CASCADE,
   FOREIGN KEY(id_user) REFERENCES user(id) ON DELETE CASCADE
);

CREATE TABLE shared_financing_scen(
   id_group INT,
   id_finScen INT,
   id_user INT,
   PRIMARY KEY(id_group, id_finScen, id_user),
   FOREIGN KEY(id_group) REFERENCES project_group(id) ON DELETE CASCADE,
   FOREIGN KEY(id_finScen) REFERENCES financing_scenario(id) ON DELETE CASCADE,
   FOREIGN KEY(id_user) REFERENCES user(id) ON DELETE CASCADE
);

CREATE TABLE privileges(
   id_group INT,
   id_user INT,
   id_role INT,
   code INT,
   PRIMARY KEY(id_group, id_user, id_role),
   FOREIGN KEY(id_group) REFERENCES project_group(id) ON DELETE CASCADE,
   FOREIGN KEY(id_user) REFERENCES user(id) ON DELETE CASCADE,
   FOREIGN KEY(id_role) REFERENCES role(id) ON DELETE CASCADE
);

CREATE TABLE ucm_sel_measure(
   id_meas INT,
   id_ucm INT,
   PRIMARY KEY(id_meas, id_ucm),
   FOREIGN KEY(id_meas) REFERENCES measure(id) ON DELETE CASCADE,
   FOREIGN KEY(id_ucm) REFERENCES use_cases_menu(id) ON DELETE CASCADE
);

CREATE TABLE capex_uc(
   id_item INT NOT NULL,
   id_uc INT NOT NULL,
   PRIMARY KEY(id_item,id_uc),
   FOREIGN KEY(id_item) REFERENCES capex_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE
);

CREATE TABLE opex_uc(
   id_item INT NOT NULL,
   id_uc INT NOT NULL,
   PRIMARY KEY(id_item,id_uc),
   FOREIGN KEY(id_item) REFERENCES opex_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE
);

CREATE TABLE implem_uc(
   id_item INT NOT NULL,
   id_uc INT NOT NULL,
   PRIMARY KEY(id_item,id_uc),
   FOREIGN KEY(id_item) REFERENCES implem_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE
);

CREATE TABLE revenues_uc(
   id_item INT NOT NULL,
   id_uc INT NOT NULL,
   PRIMARY KEY(id_item,id_uc),
   FOREIGN KEY(id_item) REFERENCES revenues_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE
);

CREATE TABLE cashreleasing_uc(
   id_item INT NOT NULL,
   id_uc INT NOT NULL,
   PRIMARY KEY(id_item,id_uc),
   FOREIGN KEY(id_item) REFERENCES cashreleasing_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE
);

CREATE TABLE noncash_uc(
   id_item INT NOT NULL,
   id_uc INT NOT NULL,
   PRIMARY KEY(id_item,id_uc),
   FOREIGN KEY(id_item) REFERENCES noncash_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE
);

CREATE TABLE widercash_uc(
   id_item INT NOT NULL,
   id_uc INT NOT NULL,
   PRIMARY KEY(id_item,id_uc),
   FOREIGN KEY(id_item) REFERENCES widercash_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE
);

CREATE TABLE risk_uc(
   id_item INT NOT NULL,
   id_uc INT NOT NULL,
   PRIMARY KEY(id_item,id_uc),
   FOREIGN KEY(id_item) REFERENCES risk_item(id) ON DELETE CASCADE,
   FOREIGN KEY(id_uc) REFERENCES use_case(id) ON DELETE CASCADE
);

CREATE TABLE matrix_bm_1(
   id_investcap INT NOT NULL,
   id_payconst INT NOT NULL,
   id_bmpref INT NOT NULL,
   in_house INT NOT NULL,
   PPP INT NOT NULL,
   outsourced INT NOT NULL,
   PRIMARY KEY(id_investcap,id_payconst,id_bmpref),
   FOREIGN KEY(id_investcap) REFERENCES invest_capacity(id) ON DELETE CASCADE,
   FOREIGN KEY(id_payconst) REFERENCES payback_constraints(id) ON DELETE CASCADE,
   FOREIGN KEY(id_bmpref) REFERENCES business_model_pref(id) ON DELETE CASCADE
);

CREATE TABLE business_model_reco(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   PRIMARY KEY (id)
);

CREATE TABLE bm_bankability(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   description VARCHAR(255),
   PRIMARY KEY(id)
);

CREATE TABLE bm_soc_bankability(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   description VARCHAR(255),
   PRIMARY KEY(id)
);

CREATE TABLE bm_funding_opt_perc(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   description VARCHAR(255),
   PRIMARY KEY(id)
);

CREATE TABLE matrix_bm_2(
   id_bm INT NOT NULL,
   id_investcap INT NOT NULL,
   id_bank INT NOT NULL,
   id_socbank INT NOT NULL,

   city INT DEFAULT NULL,
   grants INT DEFAULT NULL,
   eq_investors INT DEFAULT NULL,
   impact_investors INT DEFAULT NULL,
   bank_debt INT DEFAULT NULL,
   green_debt INT DEFAULT NULL,
   suppliers INT DEFAULT NULL,
   alternative INT DEFAULT NULL,
   
   PRIMARY KEY(id_bm,id_investcap,id_bank,id_socbank),
   FOREIGN KEY(id_bm) REFERENCES business_model_reco(id) ON DELETE CASCADE,
   FOREIGN KEY(id_investcap) REFERENCES invest_capacity(id) ON DELETE CASCADE,
   FOREIGN KEY(id_bank) REFERENCES bm_bankability(id) ON DELETE CASCADE,
   FOREIGN KEY(id_socbank) REFERENCES bm_soc_bankability(id) ON DELETE CASCADE
);