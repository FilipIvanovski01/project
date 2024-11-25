CREATE TABLE Categories(
   id VARCHAR(50) PRIMARY KEY NOT NULL,
   category VARCHAR(50)
);
INSERT INTO Categories(id,category) VALUES
('all', 'all'),
('clothes', 'clothes'),
('tech', 'tech');

CREATE TABLE Brands (
    id VARCHAR(50) PRIMARY KEY NOT NULL,
    brand VARCHAR(50)
);

INSERT INTO Brands(id, brand) VALUES 
('Nike x Stussy', 'Nike x Stussy'),
('Canada Goose', 'Canada Goose'),
('Sony', 'Sony'),
('Microsoft', 'Microsoft'),
('Apple', 'Apple');

CREATE TABLE Products (
    id VARCHAR(50) PRIMARY KEY NOT NULL,
    product_name VARCHAR(50) NOT NULL,
    in_stock BOOLEAN NOT NULL,
    description TEXT,
    category_id VARCHAR(50) NOT NULL,
    brand_id VARCHAR(50) NOT NULL,
    
    FOREIGN KEY (category_id) REFERENCES Categories(id),
    FOREIGN KEY (brand_id) REFERENCES Brands(id)
);

INSERT INTO Products(id, product_name, in_stock, description, category_id, brand_id) VALUES
('huarache-x-stussy-le', 'Nike Air Huarache Le', TRUE, '<p>Great sneakers for everyday use!</p>', 'clothes', 'Nike x Stussy'),
('jacket-canada-goosee', 'Jacket', TRUE, '<p>Awesome winter jacket</p>', 'clothes', 'Canada Goose'),
('ps-5', 'PlayStation 5', TRUE, '<p>A good gaming console. Plays games of PS4! Enjoy if you can buy it mwahahahaha</p>', 'tech', 'Sony'),
('xbox-series-s', 'Xbox Series S 512GB', FALSE, '<div><ul><li><span>Hardware-beschleunigtes Raytracing macht dein Spiel noch realistischer</span></li><li><span>Spiele Games mit bis zu 120 Bilder pro Sekunde</span></li><li><span>Minimiere Ladezeiten mit einer speziell entwickelten 512GB NVMe SSD und wechsle mit Quick Resume nahtlos zwischen mehreren Spielen.</span></li><li><span>Xbox Smart Delivery stellt sicher, dass du die beste Version deines Spiels spielst, egal, auf welcher Konsole du spielst</span></li><li><span>Spiele deine Xbox One-Spiele auf deiner Xbox Series S weiter. Deine Fortschritte, Erfolge und Freundesliste werden automatisch auf das neue System übertragen.</span></li><li><span>Erwecke deine Spiele und Filme mit innovativem 3D Raumklang zum Leben</span></li><li><span>Der brandneue Xbox Wireless Controller zeichnet sich durch höchste Präzision, eine neue Share-Taste und verbesserte Ergonomie aus</span></li><li><span>Ultra-niedrige Latenz verbessert die Reaktionszeit von Controller zum Fernseher</span></li><li><span>Verwende dein Xbox One-Gaming-Zubehör -einschließlich Controller, Headsets und mehr</span></li><li><span>Erweitere deinen Speicher mit der Seagate 1 TB-Erweiterungskarte für Xbox Series X (separat erhältlich) und streame 4K-Videos von Disney+, Netflix, Amazon, Microsoft Movies &amp; TV und mehr</span></li></ul></div>', 'tech', 'Microsoft'),
('apple-imac-2021', 'iMac 2021', TRUE, 'The new iMac!', 'tech', 'Apple'),
('apple-iphone-12-pro', 'iPhone 12 Pro', TRUE, 'This is iPhone 12. Nothing else to say.', 'tech', 'Apple'),
('apple-airpods-pro', 'AirPods Pro', FALSE, '<h3>Magic like you’ve never heard</h3><p>AirPods Pro have been designed to deliver Active Noise Cancellation for immersive sound, Transparency mode so you can hear your surroundings, and a customizable fit for all-day comfort. Just like AirPods, AirPods Pro connect magically to your iPhone or Apple Watch. And they’re ready to use right out of the case.<h3>Active Noise Cancellation</h3><p>Incredibly light noise-cancelling headphones, AirPods Pro block out your environment so you can focus on what you’re listening to. AirPods Pro use two microphones, an outward-facing microphone and an inward-facing microphone, to create superior noise cancellation. By continuously adapting to the geometry of your ear and the fit of the ear tips, Active Noise Cancellation silences the world to keep you fully tuned in to your music, podcasts, and calls.<h3>Transparency mode</h3><p>Switch to Transparency mode and AirPods Pro let the outside sound in, allowing you to hear and connect to your surroundings. Outward- and inward-facing microphones enable AirPods Pro to undo the sound-isolating effect of the silicone tips so things sound and feel natural, like when you’re talking to people around you.</p><h3>All-new design</h3><p>AirPods Pro offer a more customizable fit with three sizes of flexible silicone tips to choose from. With an internal taper, they conform to the shape of your ear, securing your AirPods Pro in place and creating an exceptional seal for superior noise cancellation.</p><h3>Amazing audio quality</h3><p>A custom-built high-excursion, low-distortion driver delivers powerful bass. A superefficient high dynamic range amplifier produces pure, incredibly clear sound while also extending battery life. And Adaptive EQ automatically tunes music to suit the shape of your ear for a rich, consistent listening experience.</p><h3>Even more magical</h3><p>The Apple-designed H1 chip delivers incredibly low audio latency. A force sensor on the stem makes it easy to control music and calls and switch between Active Noise Cancellation and Transparency mode. Announce Messages with Siri gives you the option to have Siri read your messages through your AirPods. And with Audio Sharing, you and a friend can share the same audio stream on two sets of AirPods — so you can play a game, watch a movie, or listen to a song together.</p>', 'tech', 'Apple'),
('apple-airtag', 'AirTag', TRUE, '<h1>Lose your knack for losing things.</h1><p>AirTag is an easy way to keep track of your stuff. Attach one to your keys, slip another one in your backpack. And just like that, they’re on your radar in the Find My app. AirTag has your back.</p>', 'tech', 'Apple');

CREATE TABLE Currency(
    id VARCHAR(10) NOT NULL,
    currency_label VARCHAR(10) NOT NULL,
    currency_symbol VARCHAR(10) NOT NULL,
    PRIMARY KEY(id)
);

INSERT INTO Currency(id, currency_label, currency_symbol) VALUES
('USD', 'USD', '$');

CREATE TABLE ProductPrice(
    product_id VARCHAR(50) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    currency_id VARCHAR(10) NOT NULL,
    
    PRIMARY KEY (product_id, amount),

    FOREIGN KEY (product_id) REFERENCES Products(id) ON DELETE CASCADE,
    FOREIGN KEY (currency_id) REFERENCES Currency(id)
);

INSERT INTO ProductPrice(product_id, amount, currency_id) VALUES 
('huarache-x-stussy-le', 144.69, 'USD'), 
('jacket-canada-goosee', 518.47, 'USD'), 
('ps-5', 844.02, 'USD'), 
('xbox-series-s', 333.99, 'USD'), 
('apple-imac-2021', 1688.03, 'USD'), 
('apple-iphone-12-pro', 1000.76, 'USD'), 
('apple-airpods-pro', 300.23, 'USD'), 
('apple-airtag', 120.57, 'USD');

CREATE TABLE ProductGallery(
    product_id VARCHAR(50) NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    
    PRIMARY KEY (product_id, image_url),
    
    FOREIGN KEY (product_id) REFERENCES Products(id) ON DELETE CASCADE
);

INSERT INTO ProductGallery(product_id, image_url) VALUES
('huarache-x-stussy-le', 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_2_720x.jpg?v=1612816087'),
('huarache-x-stussy-le', 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_1_720x.jpg?v=1612816087'),
('huarache-x-stussy-le', 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_3_720x.jpg?v=1612816087'),
('huarache-x-stussy-le', 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_5_720x.jpg?v=1612816087'),
('huarache-x-stussy-le', 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_4_720x.jpg?v=1612816087'),
('jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016105/product-image/2409L_61.jpg'),
('jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016107/product-image/2409L_61_a.jpg'),
('jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016108/product-image/2409L_61_b.jpg'),
('jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016109/product-image/2409L_61_c.jpg'),
('jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016110/product-image/2409L_61_d.jpg'),
('jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_1333,c_scale,f_auto,q_auto:best/v1634058169/product-image/2409L_61_o.png'),
('jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_1333,c_scale,f_auto,q_auto:best/v1634058159/product-image/2409L_61_p.png'),
('ps-5', 'https://images-na.ssl-images-amazon.com/images/I/510VSJ9mWDL._SL1262_.jpg'),
('ps-5', 'https://images-na.ssl-images-amazon.com/images/I/610%2B69ZsKCL._SL1500_.jpg'),
('ps-5', 'https://images-na.ssl-images-amazon.com/images/I/51iPoFwQT3L._SL1230_.jpg'),
('ps-5', 'https://images-na.ssl-images-amazon.com/images/I/61qbqFcvoNL._SL1500_.jpg'),
('ps-5', 'https://images-na.ssl-images-amazon.com/images/I/51HCjA3rqYL._SL1230_.jpg'),
('xbox-series-s', 'https://images-na.ssl-images-amazon.com/images/I/71vPCX0bS-L._SL1500_.jpg'),
('xbox-series-s', 'https://images-na.ssl-images-amazon.com/images/I/71q7JTbRTpL._SL1500_.jpg'),
('xbox-series-s', 'https://images-na.ssl-images-amazon.com/images/I/71iQ4HGHtsL._SL1500_.jpg'),
('xbox-series-s', 'https://images-na.ssl-images-amazon.com/images/I/61IYrCrBzxL._SL1500_.jpg'),
('xbox-series-s', 'https://images-na.ssl-images-amazon.com/images/I/61RnXmpAmIL._SL1500_.jpg'),
('apple-imac-2021', 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/imac-24-blue-selection-hero-202104?wid=904&hei=840&fmt=jpeg&qlt=80&.v=1617492405000'),
('apple-iphone-12-pro', 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-12-pro-family-hero?wid=940&amp;hei=1112&amp;fmt=jpeg&amp;qlt=80&amp;.v=1604021663000'),
('apple-airpods-pro', 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MWP22?wid=572&hei=572&fmt=jpeg&qlt=95&.v=1591634795000'),
('apple-airtag', 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/airtag-double-select-202104?wid=445&hei=370&fmt=jpeg&qlt=95&.v=1617761672000');

CREATE TABLE AttributeType(
    id VARCHAR(50) PRIMARY KEY,
    attribute_type VARCHAR(50) NOT NULL
);

INSERT INTO AttributeType(id,attribute_type) VALUES
("Size","Size"),
("Color","Color"),
("Capacity","Capacity"),
("With USB 3 ports","With USB 3 ports"),
("Touch ID in keyboard","Touch ID in keyboard");


CREATE TABLE Attribute(
    id INT AUTO_INCREMENT PRIMARY KEY,
    attribute_type VARCHAR(50) NOT NULL,
    value VARCHAR(50) NOT NULL,
    display_value VARCHAR(50),

    FOREIGN KEY (attribute_type) REFERENCES AttributeType(id)
)

INSERT INTO Attribute(attribute_type, value, display_value) VALUES 
("Size", "40", "40"),
("Size", "41", "41"),
("Size", "42", "42"),
("Size", "43", "43"),
("Size", "S", "Small"),
("Size", "M", "Medium"),
("Size", "L", "Large"),
("Size", "XL", "Extra Large"),
("Color", "#44FF03", "Green"),
("Color", "#03FFF7", "Cyan"),
("Color", "#030BFF", "Blue"),
("Color", "#000000", "Black"),
("Color", "#FFFFFF", "White"),
("Capacity", "512G", "512G"),
("Capacity", "1T", "1T"),
("Capacity", "256GB", "256GB"),
("Capacity", "512GB", "512GB"),
("With USB 3 ports", "Yes", "Yes"),
("With USB 3 ports", "No", "No"),
("Touch ID in keyboard", "Yes", "Yes"),
("Touch ID in keyboard", "No", "No");

CREATE TABLE ProductAttribute(
    product_id VARCHAR(50) NOT NULL,
    attribute_id INT NOT NULL,

    PRIMARY KEY (product_id,attribute_id)

    FOREIGN KEY (product_id) REFERENCES Products(id)
    FOREIGN KEY (attribute_id) REFERENCES Attribute(id)
);

INSERT INTO ProductAttribute(product_id,attribute_id) VALUES 
("huarache-x-stussy-le", "1"),
("huarache-x-stussy-le", "2"),
("huarache-x-stussy-le", "3"),
("huarache-x-stussy-le", "4"),
("jacket-canada-goosee", "5"),
("jacket-canada-goosee", "6"),
("jacket-canada-goosee", "7"),
("jacket-canada-goosee", "8"),
("ps-5", "9"),
("ps-5", "10"),
("ps-5", "11"),
("ps-5", "12"),
("ps-5", "13"),
("ps-5", "14"),
("ps-5", "15"),
("xbox-series-s", "9"),
("xbox-series-s", "10"),
("xbox-series-s", "11"),
("xbox-series-s", "12"),
("xbox-series-s", "13"),
("xbox-series-s", "14"),
("xbox-series-s", "15"),
("apple-imac-2021", "16"),
("apple-imac-2021", "17"),
("apple-imac-2021", "18"),
("apple-imac-2021", "19"),
("apple-imac-2021", "20"),
("apple-imac-2021", "21"),
("apple-iphone-12-pro", "14"),
("apple-iphone-12-pro", "15"),
("apple-iphone-12-pro", "9"),
("apple-iphone-12-pro", "10"),
("apple-iphone-12-pro", "11"),
("apple-iphone-12-pro", "12"),
("apple-iphone-12-pro", "13");

CREATE TABLE Orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id VARCHAR(50) NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (product_id) REFERENCES Products(id)  
);

CREATE TABLE ChoosenAttributesOrders (
    order_id INT NOT NULL,
    attribute_id INT NOT NULL,
    PRIMARY KEY (order_id, attribute_id),  
    FOREIGN KEY (order_id) REFERENCES Orders(id) ON DELETE CASCADE,  
    FOREIGN KEY (attribute_id) REFERENCES Attribute(id)  
);
