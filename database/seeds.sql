-- =============================================================================
-- NUAP On-Demand Beverage Delivery Platform
-- Seed Data: Cold Beverages, Spirits, Mixers, Ice & Snacks
-- =============================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Users
-- Passwords hashed with bcrypt: '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' -> 'password'
INSERT INTO `users` (`id`, `email`, `phone`, `phone_validated`, `phone_validated_date`, `password`, `api_token`, `status`, `role`, `last_logged_in`, `created_at`, `updated_at`) VALUES
(1, 'admin@nuapdelivery.com', '3001234567', 1, '2021-01-15 10:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tok_admin_f8392019485720192837482910394857', 1, 'Administrador', '2023-01-10 08:30:00', '2021-01-10 12:00:00', '2023-01-10 08:30:00'),
(2, 'contacto@bodegachapinero.co', '3109876543', 1, '2021-02-01 11:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tok_comm_chapinero_83920194827102948571', 1, 'Comercio', '2023-01-15 14:20:00', '2021-02-01 10:00:00', '2023-01-15 14:20:00'),
(3, 'pedidos@licoreraelpoblado.com', '3128765432', 1, '2021-02-05 09:30:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tok_comm_poblado_94827102938475610293', 1, 'Comercio', '2023-01-18 16:45:00', '2021-02-05 09:00:00', '2023-01-18 16:45:00'),
(4, 'deposito@granadacali.com', '3157654321', 1, '2021-02-10 08:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tok_comm_granada_10293847561029384756', 1, 'Comercio', '2023-01-20 18:00:00', '2021-02-10 08:00:00', '2023-01-20 18:00:00'),
(5, 'rider1@enviosflash.co', '3206543210', 1, '2021-02-15 12:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tok_dist_flash_58392019482710293847', 1, 'Distribuidor', '2023-01-22 19:10:00', '2021-02-15 12:00:00', '2023-01-22 19:10:00'),
(6, 'cliente.carlos@gmail.com', '3015432109', 1, '2021-03-01 15:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tok_client_carlos_493820194827102948', 1, 'Usuario', '2023-01-25 21:00:00', '2021-03-01 14:30:00', '2023-01-25 21:00:00'),
(7, 'valentina.gomez@outlook.com', '3024321098', 1, '2021-03-10 17:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tok_client_valentina_39201948271029', 1, 'Usuario', '2023-01-26 22:15:00', '2021-03-10 16:40:00', '2023-01-26 22:15:00');

-- 2. Admin Users
INSERT INTO `admin_users` (`id`, `user_id`, `name`, `last_name`, `identity_number`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 1, 'Kevin', 'Herrera', '1032489201', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb', '2021-01-10 12:00:00', '2021-01-10 12:00:00');

-- 3. Distributors (Couriers / Delivery Fleet)
INSERT INTO `distributors` (`id`, `user_id`, `business_name`, `nit`, `second_phone`, `commission`, `type`, `name_legal_representative`, `cc_legal_representative`, `contact_legal_representative`, `url_rut`, `url_commerce_room`, `url_cc_legal_representative`, `url_establishment_image`, `url_interior_image`, `url_contract`, `created_at`, `updated_at`) VALUES
(1, 5, 'Envios Flash Express SAS', '901238471-2', '3206543211', 10.0, 'Distribuidor', 'Mateo Morales', '1029384756', '3206543210', '/docs/rut_flash.pdf', '/docs/cc_flash.pdf', '/docs/id_mateo.pdf', '/img/fleet_ext.jpg', '/img/fleet_int.jpg', '/docs/contract_flash.pdf', '2021-02-15 12:00:00', '2021-02-15 12:00:00');

-- 4. Commerces (Partner Stores / Bodegas)
INSERT INTO `commerces` (`id`, `user_id`, `business_name`, `nit`, `second_phone`, `commission`, `type`, `name_legal_representative`, `cc_legal_representative`, `contact_legal_representative`, `url_rut`, `url_commerce_room`, `url_cc_legal_representative`, `url_establishment_image`, `url_interior_image`, `url_contract`, `created_at`, `updated_at`) VALUES
(1, 2, 'Bodega Express Chapinero', '900847291-1', '6017482910', 12.5, 'Licorera', 'Andres Felipe Castro', '80192847', '3109876543', '/docs/rut_chapinero.pdf', '/docs/cc_chapinero.pdf', '/docs/id_castro.pdf', '/img/chapinero_facade.jpg', '/img/chapinero_inside.jpg', '/docs/contract_chapinero.pdf', '2021-02-01 10:00:00', '2021-02-01 10:00:00'),
(2, 3, 'Licoreria El Poblado', '900958372-4', '6044482910', 12.0, 'Licorera', 'Camila Restrepo', '43281920', '3128765432', '/docs/rut_poblado.pdf', '/docs/cc_poblado.pdf', '/docs/id_camila.pdf', '/img/poblado_facade.jpg', '/img/poblado_inside.jpg', '/docs/contract_poblado.pdf', '2021-02-05 09:00:00', '2021-02-05 09:00:00'),
(3, 4, 'Deposito Cervecero Granada', '901029384-5', '6028892019', 11.0, 'Supermercado', 'Diego Fernando Marin', '16782910', '3157654321', '/docs/rut_granada.pdf', '/docs/cc_granada.pdf', '/docs/id_diego.pdf', '/img/granada_facade.jpg', '/img/granada_inside.jpg', '/docs/contract_granada.pdf', '2021-02-10 08:00:00', '2021-02-10 08:00:00');

-- 5. Clients
INSERT INTO `clients` (`id`, `user_id`, `name`, `last_name`, `identity_number`, `created_at`, `updated_at`) VALUES
(1, 6, 'Carlos', 'Mendoza Ramos', '1018273645', '2021-03-01 14:30:00', '2021-03-01 14:30:00'),
(2, 7, 'Valentina', 'Gomez Jaramillo', '1037281920', '2021-03-10 16:40:00', '2021-03-10 16:40:00');

-- 6. User Locations (Delivery Addresses with real coordinates)
INSERT INTO `user_locations` (`id`, `user_id`, `city`, `location`, `neighborhood`, `address`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 2, 'Bogota', 'Chapinero', 'Lourdes', 'Calle 63 # 9-45', '4.649210', '-74.062830', '2021-02-01 10:15:00', '2021-02-01 10:15:00'),
(2, 3, 'Medellin', 'El Poblado', 'Parque Lleras', 'Carrera 37 # 8A-12', '6.208720', '-75.567840', '2021-02-05 09:15:00', '2021-02-05 09:15:00'),
(3, 4, 'Cali', 'Granada', 'Granada', 'Avenida 9N # 14-22', '3.456120', '-76.533210', '2021-02-10 08:15:00', '2021-02-10 08:15:00'),
(4, 6, 'Bogota', 'Chapinero', 'Antiguo Country', 'Calle 85 # 14-30 Apto 402', '4.668540', '-74.056720', '2021-03-01 14:45:00', '2021-03-01 14:45:00'),
(5, 7, 'Medellin', 'El Poblado', 'La Florida', 'Calle 10 sur # 43A-25 Torre 1', '6.195430', '-75.578120', '2021-03-10 17:10:00', '2021-03-10 17:10:00');

-- 7. Categories
INSERT INTO `categories` (`id`, `parent_id`, `name`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 0, 'Cervezas Nacionales', 'Cervezas frias tradicionales y de malta pura', 'https://images.unsplash.com/photo-1608270199042-3a36db5538e1', '2021-01-10 12:00:00', '2021-01-10 12:00:00'),
(2, 0, 'Cervezas Artesanales e Importadas', 'Seleccion de cervezas rubias, rojas y lupuladas', 'https://images.unsplash.com/photo-1535958636474-b021ee887b13', '2021-01-10 12:00:00', '2021-01-10 12:00:00'),
(3, 0, 'Licores y Destilados', 'Aguardientes, rones anejos, whiskies y destilados finos', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4', '2021-01-10 12:00:00', '2021-01-10 12:00:00'),
(4, 0, 'Bebidas No Alcoholicas', 'Gaseosas, tonicas, mixers refrescantes y agua purificada', 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97', '2021-01-10 12:00:00', '2021-01-10 12:00:00'),
(5, 0, 'Snacks y Pasabocas', 'Papas crujientes, mani tostado y frutos secos', 'https://images.unsplash.com/photo-1566478989037-eec170784d0b', '2021-01-10 12:00:00', '2021-01-10 12:00:00'),
(6, 0, 'Hielo y Complementos', 'Bolsas de hielo purificado y articulos de servicio', 'https://images.unsplash.com/photo-1517646287270-a5a9ca602e5c', '2021-01-10 12:00:00', '2021-01-10 12:00:00');

-- 8. Products
INSERT INTO `products` (`id`, `user_id`, `category_id`, `name`, `brand`, `description`, `status`, `is_featured`, `stock`, `weight`, `length`, `width`, `height`, `purchase_price`, `sale_price`, `special_price`, `has_special_price`, `image`, `position`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Cerveza Dorada Premium Six-Pack 330ml', 'Cerveceria Nacional', 'Pack de 6 unidades de cerveza rubia con malta seleccionada bien fria.', 1, 1, 120, 2.1, 20.0, 13.0, 12.0, 18000.0, 24000.0, 22000.0, 1, 'https://images.unsplash.com/photo-1608270199042-3a36db5538e1', 1, '2021-02-01 10:30:00', '2021-02-01 10:30:00'),
(2, 2, 1, 'Cerveza Ligera Refrescante Six-Pack 330ml', 'Cerveceria Nacional', 'Cerveza rubia de cuerpo ligero y balanceada temperatura ideal.', 1, 1, 200, 2.1, 20.0, 13.0, 12.0, 15000.0, 20000.0, 18500.0, 1, 'https://images.unsplash.com/photo-1618886614638-80e3c15cd819', 2, '2021-02-01 10:35:00', '2021-02-01 10:35:00'),
(3, 2, 1, 'Cerveza Clasica Tradicional Six-Pack 330ml', 'Cerveceria Nacional', 'Cerveza dorada de tradicion familiar y cuerpo robusto.', 1, 0, 180, 2.1, 20.0, 13.0, 12.0, 14000.0, 19000.0, 0.0, 0, 'https://images.unsplash.com/photo-1608270199042-3a36db5538e1', 3, '2021-02-01 10:40:00', '2021-02-01 10:40:00'),
(4, 2, 2, 'Cerveza Rubia Extra Botella Six-Pack 355ml', 'Importada Premium', 'Cerveza lager clara refrescante para acompanar con rodajas citricas.', 1, 1, 90, 2.8, 22.0, 15.0, 23.0, 26000.0, 36000.0, 32900.0, 1, 'https://images.unsplash.com/photo-1584225064785-c62a8b43d148', 4, '2021-02-01 10:45:00', '2021-02-01 10:45:00'),
(5, 2, 2, 'Cerveza Artesanal Roja 330ml Six-Pack', 'Artesanal Andina', 'Cerveza tipo Ale con maltas caramelo y aroma lupulado fino.', 1, 1, 85, 2.7, 21.0, 14.0, 22.0, 27000.0, 38000.0, 34500.0, 1, 'https://images.unsplash.com/photo-1535958636474-b021ee887b13', 5, '2021-02-01 10:50:00', '2021-02-01 10:50:00'),
(6, 2, 3, 'Aguardiente Anisado Tradicional 750ml', 'Destileria del Valle', 'Destilado tradicional con notas dulces de anis estrella puro.', 1, 1, 60, 1.2, 8.0, 8.0, 30.0, 32000.0, 46000.0, 42000.0, 1, 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4', 6, '2021-02-01 11:00:00', '2021-02-01 11:00:00'),
(7, 2, 3, 'Ron Anejo Reserva Especial 8 Anos 750ml', 'Destileria del Valle', 'Madurado pacientemente en barricas de roble americano.', 1, 1, 45, 1.3, 9.0, 9.0, 31.0, 42000.0, 60000.0, 54900.0, 1, 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b', 7, '2021-02-01 11:05:00', '2021-02-01 11:05:00'),
(8, 2, 3, 'Whisky Escoces Reserva 12 Anos 750ml', 'Highland Spirits', 'Blended Scotch Whisky anejo con notas suaves y ahumadas.', 1, 1, 30, 1.4, 10.0, 10.0, 32.0, 85000.0, 125000.0, 115000.0, 1, 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4', 8, '2021-02-01 11:10:00', '2021-02-01 11:10:00'),
(9, 2, 4, 'Bebida Gaseosa Sabor Original 1.5L', 'Refrescos Andinos', 'Bebida refrescante gasificada clasica para celebraciones.', 1, 0, 150, 1.6, 9.0, 9.0, 32.0, 4000.0, 6500.0, 0.0, 0, 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97', 9, '2021-02-01 11:15:00', '2021-02-01 11:15:00'),
(10, 2, 4, 'Mixer Ginger Ale con Jengibre Natural 1.5L', 'Refrescos Andinos', 'Mixer con extracto de jengibre natural para preparar cocteleria.', 1, 0, 100, 1.6, 9.0, 9.0, 32.0, 4200.0, 6800.0, 0.0, 0, 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97', 10, '2021-02-01 11:20:00', '2021-02-01 11:20:00'),
(11, 2, 5, 'Papas Fritas Onduladas con Sal Marina 110g', 'Snacks Andinos', 'Papas crujientes seleccionadas fritas con sal marina natural.', 1, 0, 80, 0.12, 18.0, 6.0, 25.0, 3000.0, 4800.0, 0.0, 0, 'https://images.unsplash.com/photo-1566478989037-eec170784d0b', 11, '2021-02-01 11:25:00', '2021-02-01 11:25:00'),
(12, 2, 6, 'Bolsa de Hielo Purificado en Cubos 3kg', 'Hielo Polar', 'Hielo cristalino elaborado con agua filtrada y purificada.', 1, 1, 100, 3.0, 30.0, 20.0, 15.0, 2500.0, 4500.0, 0.0, 0, 'https://images.unsplash.com/photo-1517646287270-a5a9ca602e5c', 12, '2021-02-01 11:30:00', '2021-02-01 11:30:00');

-- 9. Orders
INSERT INTO `orders` (`id`, `user_id`, `user_type`, `status`, `cancel_reason`, `client_id`, `client_type`, `total_products`, `total_amount`, `delivery_amount`, `total_discount`, `total`, `created_at`, `updated_at`) VALUES
(1, 2, 'Comercio', 'Entregado', NULL, 1, 'Usuario', 3, 62000.0, 4500.0, 2000.0, 64500.0, '2022-11-15 20:30:00', '2022-11-15 21:05:00'),
(2, 2, 'Comercio', 'Entregado', NULL, 2, 'Usuario', 4, 115000.0, 4500.0, 0.0, 119500.0, '2022-12-05 22:10:00', '2022-12-05 22:42:00'),
(3, 2, 'Comercio', 'Circulacion', NULL, 1, 'Usuario', 2, 42000.0, 4000.0, 0.0, 46000.0, '2023-01-20 21:15:00', '2023-01-20 21:35:00');

-- 10. Order Products
INSERT INTO `order_products` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 22000.0, '2022-11-15 20:30:00', '2022-11-15 20:30:00'),
(2, 1, 12, 1, 4500.0, '2022-11-15 20:30:00', '2022-11-15 20:30:00'),
(3, 1, 11, 1, 4800.0, '2022-11-15 20:30:00', '2022-11-15 20:30:00'),
(4, 2, 8, 1, 115000.0, '2022-12-05 22:10:00', '2022-12-05 22:10:00'),
(5, 3, 4, 1, 32900.0, '2023-01-20 21:15:00', '2023-01-20 21:15:00'),
(6, 3, 12, 1, 4500.0, '2023-01-20 21:15:00', '2023-01-20 21:15:00');

-- 11. PayU Payments
INSERT INTO `payu_payments` (`id`, `order_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2022-11-15 20:31:00', '2022-11-15 20:31:00'),
(2, 2, '2022-12-05 22:11:00', '2022-12-05 22:11:00');

-- 12. Bank Accounts
INSERT INTO `bank_accounts` (`id`, `user_id`, `user_type`, `owner_name`, `owner_document`, `account`, `account_type`, `bank`, `created_at`, `updated_at`) VALUES
(1, 2, 'Comercio', 'Andres Felipe Castro', '80192847', '2410098231', 'Ahorros', 'Bancolombia', '2021-02-01 10:20:00', '2021-02-01 10:20:00'),
(2, 5, 'Distribuidor', 'Mateo Morales', '1029384756', '0048291039', 'Corriente', 'Davivienda', '2021-02-15 12:15:00', '2021-02-15 12:15:00');

-- 13. Balances
INSERT INTO `balances` (`id`, `user_id`, `user_type`, `balance`, `paid_out`, `total`, `created_at`, `updated_at`) VALUES
(1, 2, 'Comercio', 184000.0, 500000.0, 684000.0, '2021-02-01 10:00:00', '2023-01-20 22:00:00'),
(2, 5, 'Distribuidor', 45000.0, 120000.0, 165000.0, '2021-02-15 12:00:00', '2023-01-20 22:00:00');

-- 14. Payments (Disbursements)
INSERT INTO `payments` (`id`, `user_id`, `user_type`, `account_id`, `value`, `request_date`, `payment_date`, `status`, `voucher`, `created_at`, `updated_at`) VALUES
(1, 2, 'Comercio', 1, 500000.0, '2022-12-01 09:00:00', '2022-12-02 14:00:00', 'Aprobado', '/vouchers/vouch_20221202_001.pdf', '2022-12-01 09:00:00', '2022-12-02 14:00:00');

-- 15. Tickets & Messages
INSERT INTO `tickets` (`id`, `user_id`, `user_type`, `issues`, `init_date`, `finish_date`, `is_closed`, `created_at`, `updated_at`) VALUES
(1, 6, 'Usuario', 'Consulta sobre cobertura en Bogota zona norte', '2023-01-12', '2023-01-13', 1, '2023-01-12 11:00:00', '2023-01-13 16:00:00');

INSERT INTO `ticket_messages` (`id`, `ticket_id`, `message`, `sender_id`, `sender_type`, `sender_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'Hola, me gustaria saber si entregan pedidos en Usaquen despues de las 10 PM.', 6, 'Usuario', '2023-01-12', '2023-01-12 11:00:00', '2023-01-12 11:00:00'),
(2, 1, 'Buen dia Carlos. Si, contamos con bodegas aliadas en Usaquen que atienden hasta tarde los fines de semana.', 1, 'Administrador', '2023-01-13', '2023-01-13 15:30:00', '2023-01-13 15:30:00');

-- 16. Config
INSERT INTO `config` (`id`, `shipping_cost`, `distance`, `created_at`, `updated_at`) VALUES
(1, 4000.0, 7.5, '2021-01-10 12:00:00', '2023-01-01 10:00:00');

-- 17. Session Logs
INSERT INTO `session_logs` (`id`, `user_id`, `user_type`, `login_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'Administrador', '2023-01-10 08:30:00', '2023-01-10 08:30:00'),
(2, 2, 'Comercio', '2023-01-15 14:20:00', '2023-01-15 14:20:00'),
(3, 6, 'Usuario', '2023-01-25 21:00:00', '2023-01-25 21:00:00');

SET FOREIGN_KEY_CHECKS = 1;
