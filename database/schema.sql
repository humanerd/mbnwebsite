CREATE TABLE IF NOT EXISTS admin_users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS applications (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(190) NOT NULL,
  email VARCHAR(190) NOT NULL,
  phone VARCHAR(60) NOT NULL,
  city_state VARCHAR(190) NOT NULL,
  desired_business_type VARCHAR(190) NOT NULL,
  available_capital VARCHAR(190) NOT NULL,
  financing_needed ENUM('Yes','No') NOT NULL,
  relevant_experience TEXT NOT NULL,
  timeline_to_launch VARCHAR(190) NOT NULL,
  business_reason TEXT NOT NULL,
  agreement_acknowledged TINYINT(1) NOT NULL DEFAULT 0,
  status ENUM('New','Reviewing','Qualified','Not Qualified','Contacted') NOT NULL DEFAULT 'New',
  ip_address VARCHAR(45) DEFAULT NULL,
  user_agent VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_status(status),
  INDEX idx_business(desired_business_type),
  INDEX idx_email(email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
