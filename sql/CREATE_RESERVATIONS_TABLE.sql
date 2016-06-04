CREATE TABLE RESERVATIONS
(
res_id int NOT NULL AUTO_INCREMENT,
user_id int NOT NULL,
start_time_h int NOT NULL,
start_time_m int NOT NULL,
duration_time int NOT NULL,
selected_machine int NOT NULL,
CONSTRAINT primary_key PRIMARY KEY (res_id),
CONSTRAINT foreign_key FOREIGN KEY (user_id)
REFERENCES USERS(user_id)
);