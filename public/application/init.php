CREATE TABLE spr_userlogin(userkey int(200) AUTO_INCREMENT PRIMARY KEY, name varchar(50),
                                  email varchar(50) UNIQUE KEY,password varchar(50),
                                  type varchar(50),status varchar(50)
);

CREATE TABLE spr_sellerpost(psid int(200) AUTO_INCREMENT PRIMARY KEY, username varchar(50), title varchar(100),details varchar(500),line1 varchar(100),line2 varchar(100),state varchar(50),city varchar(50),zipcode varchar(50),feature varchar(200),date varchar(50),type varchar(50),nego varchar(50),shortsale varchar(50),startdate varchar(50),clodate varchar(50),applier varchar(50),userkey varchar(200),usertype varchar(20),agentkey varchar(200),agentname varchar(50)
);

CREATE TABLE spr_agentbio (abid int(200) AUTO_INCREMENT PRIMARY KEY, agentname varchar(50), offaddress varchar(200),state varchar(50),city varchar(50),zipcode varchar(50),
licenceno varchar(50),franchise varchar(50),experience varchar(50),companyname varchar(50),fax varchar(30),brokername varchar(50),mlspublic varchar(50),mlsoffice varchar(50),status varchar(50),userkey varchar(200)
);

CREATE TABLE spr_apply (applyid int(200) AUTO_INCREMENT PRIMARY KEY,abid int(200), agentname varchar(50),
                                  offaddress varchar(200),
                                  state varchar(50),city varchar(50),zipcode varchar(50),
licenceno varchar(50),franchise varchar(50),experience varchar(50),companyname varchar(50),fax varchar(50),brokername varchar(50),mlspublic varchar(50),mlsoffice varchar(50),
psid int(200),agentkey varchar(200),userkey varchar(200)
);

CREATE TABLE spr_question (qid int(200) AUTO_INCREMENT PRIMARY KEY,too varchar(50), fromm varchar(50), question varchar(500),reply varchar(500), receiverkey varchar(200), senderkey varchar(200)
);


CREATE TABLE spr_note (nid int(200) AUTO_INCREMENT PRIMARY KEY,title varchar(100), note varchar(500), type varchar(50), userkey varchar(200)
);

CREATE TABLE spr_document (did int(200) AUTO_INCREMENT PRIMARY KEY,title varchar(100),name varchar(100), userkey varchar(200));


CREATE TABLE spr_chat (cid int(200) AUTO_INCREMENT PRIMARY KEY, msg varchar(500),doc varchar(500),image varchar(500),pdf varchar(500),type varchar(50), agentname varchar(50), username varchar(50), agentkey varchar(200), userkey varchar(200),senderdevice varchar(200)
);


CREATE TABLE spr_sellerbookmark (bid int(200) AUTO_INCREMENT PRIMARY KEY, abid varchar(200), agentname varchar(50),
                                  offaddress varchar(200),
                                  state varchar(50),city varchar(50),zipcode varchar(50),
licenceno varchar(50),franchise varchar(50),experience varchar(50),companyname varchar(50),fax varchar(30),brokername varchar(50),mlspublic varchar(50),mlsoffice varchar(50), agentkey varchar(200),
userkey varchar(200));

CREATE TABLE spr_agentbookmark (bid int(200) AUTO_INCREMENT PRIMARY KEY, psid int(200), username varchar(50),
                                  title varchar(100),details varchar(500),
                                  line1 varchar(100),line2 varchar(100),
                                  state varchar(50),city varchar(100),zipcode varchar(50),
feature varchar(200),date varchar(50),type varchar(50),nego varchar(50),shortsale varchar(50),startdate varchar(50),clodate varchar(50),applier varchar(20),userkey varchar(200),usertype varchar(20),
agentkey varchar(200),agentname varchar(50));


CREATE TABLE spr_securityquestion ( email varchar(200) UNIQUE KEY,que1 varchar(50),answer1 varchar(50),que2 varchar(50),answer2 varchar(50));
