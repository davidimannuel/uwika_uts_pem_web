-- 1. Table: categories
CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- seed data
INSERT INTO categories (name) VALUES
('Makanan'),
('Minuman'),
('Snack');


-- 2. Table: items
CREATE TABLE items (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category_id INTEGER NOT NULL REFERENCES categories(id) ON DELETE CASCADE,
    unit VARCHAR(10) NOT NULL, -- Allowed: 'PCS', 'PACK' (handled by PHP)
    pcs_per_pack INTEGER, -- Nullable: Required only if unit is 'PACK'
    pcs_stock INTEGER DEFAULT 0,
    pack_stock INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- seed data
INSERT INTO items (name, category_id, unit, pcs_per_pack, pcs_stock, pack_stock) VALUES
('Indomie', 1, 'PACK', 5, 0, 0),
('Teh Botol', 2, 'PCS', NULL, 0, 0),
('Coklat', 3, 'PACK', NULL, 0, 0);

-- 3. Table: stock_transactions (tambah / kurang stok)
CREATE TABLE stock_transactions (
    id SERIAL PRIMARY KEY,
    item_id INTEGER NOT NULL REFERENCES items(id) ON DELETE CASCADE,
    type VARCHAR(10) NOT NULL, -- Allowed: 'INBOUND', 'OUTBOUND'
    pack_quantity INTEGER NOT NULL DEFAULT 0,
    pcs_quantity INTEGER NOT NULL DEFAULT 0,
    note TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE stock_transactions;
DROP TABLE items;
DROP TABLE categories;