CREATE TABLE IF NOT EXISTS tbl_faq (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    answer TEXT NOT NULL,
    keywords TEXT, -- Kata kunci tambahan (comma-separated atau JSON string)
    embedding LONGTEXT NOT NULL -- Menyimpan koordinat vektor 1024 dimensi (JSON string)
);
