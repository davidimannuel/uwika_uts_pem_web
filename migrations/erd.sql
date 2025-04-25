-- 1. Table: categories
CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- 2. Table: items
CREATE TABLE items (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category_id INTEGER NOT NULL REFERENCES categories(id) ON DELETE CASCADE,
    unit VARCHAR(10) NOT NULL, -- Allowed: 'PCS', 'CARTON' (handled by PHP)
    pcs_per_carton INTEGER, -- Nullable: Required only if unit is 'CARTON'
    stock INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Table: inbounds (updated)
CREATE TABLE inbounds (
    id SERIAL PRIMARY KEY,
    item_id INTEGER NOT NULL REFERENCES items(id) ON DELETE CASCADE,
    quantity INTEGER NOT NULL,
    unit VARCHAR(10) NOT NULL,           -- 'PCS' or 'CARTON' (handled by PHP)
    pcs_per_carton INTEGER,              -- Nullable: filled when unit item is 'CARTON'
    note TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Table: outbounds (updated)
CREATE TABLE outbounds (
    id SERIAL PRIMARY KEY,
    item_id INTEGER NOT NULL REFERENCES items(id) ON DELETE CASCADE,
    quantity INTEGER NOT NULL,
    unit VARCHAR(10) NOT NULL,           -- 'PCS' or 'CARTON' (handled by PHP)
    pcs_per_carton INTEGER,              -- Nullable: filled when unit item is 'CARTON'
    note TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE inbounds;
DROP TABLE outbounds;
DROP TABLE items;
DROP TABLE categories;