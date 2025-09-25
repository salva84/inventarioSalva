-- Database initialization script for inventory application

USE inventory_new;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(55) NOT NULL UNIQUE,
    hash VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Genres table
CREATE TABLE IF NOT EXISTS genres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    genre VARCHAR(20) NOT NULL UNIQUE,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Consoles table
CREATE TABLE IF NOT EXISTS consoles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    consolename VARCHAR(60) NOT NULL,
    maker VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    comment TEXT,
    dateadquisition DATE NOT NULL,
    ownerid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ownerid) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_console_per_owner (consolename, ownerid)
);

-- Videogames table
CREATE TABLE IF NOT EXISTS videogames (
    id INT AUTO_INCREMENT PRIMARY KEY,
    videogamename VARCHAR(120) NOT NULL,
    consoleid INT NOT NULL,
    genreid INT NOT NULL,
    image VARCHAR(255),
    comment TEXT,
    price DECIMAL(10,2) NOT NULL,
    dateadquisition DATE NOT NULL,
    ownerid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (consoleid) REFERENCES consoles(id) ON DELETE CASCADE,
    FOREIGN KEY (genreid) REFERENCES genres(id) ON DELETE CASCADE,
    FOREIGN KEY (ownerid) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_videogame_per_owner (videogamename, ownerid)
);

-- Insert some sample genres
INSERT INTO genres (genre, image) VALUES 
('Acción', 'action.jpg'),
('Aventura', 'adventure.jpg'),
('Estrategia', 'strategy.jpg'),
('Deportes', 'sports.jpg'),
('Carreras', 'racing.jpg'),
('RPG', 'rpg.jpg'),
('Plataformas', 'platform.jpg'),
('Puzzle', 'puzzle.jpg')
ON DUPLICATE KEY UPDATE genre=genre;

-- Insert a sample user (password: 'admin123')
INSERT INTO users (username, hash, image) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin.jpg')
ON DUPLICATE KEY UPDATE username=username;
