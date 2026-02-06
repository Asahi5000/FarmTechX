CREATE DATABASE farmtechx_db;
USE farmtechx_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Admin','Staff') DEFAULT 'Staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default admin
INSERT INTO users (name, username, password, role) VALUES
('John Owen','admin', 'admin', 'Admin');


CREATE TABLE sensors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    temperature FLOAT NOT NULL,
    tds FLOAT NOT NULL,
    ec FLOAT NOT NULL,
    ph FLOAT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



CREATE TABLE pump_control (
  id INT PRIMARY KEY,
  state VARCHAR(3) NOT NULL
);

INSERT INTO pump_control (id, state) VALUES (1, 'OFF');

-- ================= DOSING PUMP TABLE =================
CREATE TABLE dosing_pumps (
  pump CHAR(1) PRIMARY KEY,
  state ENUM('ON','OFF') DEFAULT 'OFF'
);

INSERT INTO dosing_pumps (pump, state) VALUES
('A','OFF'),
('B','OFF'),
('C','OFF');


CREATE TABLE IF NOT EXISTS soil_data (
    id INT PRIMARY KEY AUTO_INCREMENT,
    sensor_id INT NOT NULL,
    moisture FLOAT NOT NULL,
    temperature FLOAT DEFAULT 0,
    ph FLOAT NOT NULL,
    ec FLOAT NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS rain_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sensor_id INT NOT NULL,
    is_raining TINYINT(1) NOT NULL,   -- 1 = raining, 0 = no rain
    intensity INT NOT NULL,           -- 0–1023
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX(sensor_id)
);


ALTER TABLE pump_control
ADD COLUMN start_time DATETIME NULL,
ADD COLUMN duration_minutes INT DEFAULT 0,
ADD COLUMN end_time DATETIME NULL;


ALTER TABLE dosing_pumps
ADD COLUMN start_time DATETIME NULL,
ADD COLUMN duration_minutes INT DEFAULT 0,
ADD COLUMN end_time DATETIME NULL;

ALTER TABLE pump_control
ADD COLUMN duration_seconds INT DEFAULT 0 AFTER duration_minutes;

ALTER TABLE dosing_pumps
ADD COLUMN duration_seconds INT DEFAULT 0 AFTER duration_minutes;


CREATE TABLE water_schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hour INT NOT NULL,
    minute INT NOT NULL,
    ampm ENUM('AM','PM') NOT NULL,
    duration INT NOT NULL,
    last_executed DATE DEFAULT NULL
);
