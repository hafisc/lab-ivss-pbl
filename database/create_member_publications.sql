CREATE TABLE IF NOT EXISTS member_publications (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    title VARCHAR(255) NOT NULL,
    authors TEXT,
    journal VARCHAR(255),
    year INTEGER,
    doi VARCHAR(255),
    status VARCHAR(50) DEFAULT 'draft',
    file_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX IF NOT EXISTS idx_member_publications_user ON member_publications(user_id);
