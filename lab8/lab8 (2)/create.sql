CREATE TABLE clients (
	id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    surname VARCHAR(255),
    phone VARCHAR(255),
    address VARCHAR(255)
);

CREATE TABLE credit_type (
	id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    stavka INT,
    num_of_days INT
);

CREATE TABLE credit (
	id INT PRIMARY KEY AUTO_INCREMENT,
    id_credit_type INT,
    id_client INT,
    sum INT,
    date DATE,
    FOREIGN KEY (id_credit_type) REFERENCES credit_type(id),
    FOREIGN KEY (id_client) REFERENCES clients(id)
);
    