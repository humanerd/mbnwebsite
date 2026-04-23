INSERT INTO admin_users (email, password_hash)
VALUES ('admin@mbn.local', '$2y$10$KLe8D75jUp7YpGfSbq0VhOoU2nuXwygJY.EIk6CyvN7PA8q4j80jC');

INSERT INTO applications
(full_name, email, phone, city_state, desired_business_type, available_capital, financing_needed, relevant_experience, timeline_to_launch, business_reason, agreement_acknowledged, status, ip_address, user_agent)
VALUES
('Sample Operator', 'operator@example.com', '555-0100', 'Houston, TX', 'Mobile Pet Grooming', '$180,000', 'No', '5 years operations management and customer service.', '90-120 days', 'Seeking structured launch model with predictable scope.', 1, 'Reviewing', '127.0.0.1', 'Seeder');
