CREATE DATABASE IF NOT EXISTS recursive_file_structure;

CREATE TABLE IF NOT EXISTS files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    parent_id INT,
    is_directory TINYINT(1) NOT NULL DEFAULT 0,
    data BLOB,
    FOREIGN KEY (parent_id) REFERENCES files(id),
    CONSTRAINT unique_name_per_parent UNIQUE (parent_id, name)
);
