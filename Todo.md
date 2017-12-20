Todo
====

### Grammar
- [x] CSS Mobile
- [x] single quotation marks regular expression
- [ ] Javascript Child toggle (description, example, word)
- [ ] Javascript Exercise

### Font
- [ ] Primary hits count display

### Utilities
- [ ] Events(home)
- [ ] Quote(?)
- [ ] Week number(home)
- [ ] Time in myanmar(home)
- [ ] Donation(paypal)

### Database
- [ ] rename table

### API
- [ ] disable and enable for local

### Ads
- [ ] customize google adsense


users
  userid -> unique
  password -> Null auto
users_desc
  userid -> unique


ALTER TABLE users MODIFY password varchar(255) null;
ALTER TABLE users CHANGE password password type DEFAULT NULL;

ALTER TABLE `users` CHANGE `password` `password` VARCHAR(225) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;


ALTER TABLE users ADD userid INT PRIMARY KEY AUTO_INCREMENT;
ALTER TABLE users MODIFY userid INT PRIMARY KEY AUTO_INCREMENT;

ALTER TABLE users_desc ADD UNIQUE(userid);
ALTER TABLE users_desc MODIFY UNIQUE(userid);

ALTER IGNORE TABLE users_desc ADD UNIQUE (userid);



TRUNCATE TABLE users_desc;
TRUNCATE table users;
