-- Create database
CREATE DATABASE IF NOT EXISTS patient_management;
USE patient_management;

-- Users table for authentication
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Patient profiles table
CREATE TABLE patient_profiles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    patient_id VARCHAR(10) UNIQUE NOT NULL,
    age INT,
    gender ENUM('Male', 'Female', 'Other'),
    blood_group VARCHAR(5),
    disease VARCHAR(100),
    symptoms TEXT,
    medications TEXT,
    lab_tests TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);