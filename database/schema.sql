CREATE TABLE IF NOT EXISTS users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'doctor', 'patient') NOT NULL DEFAULT 'patient',
    gender ENUM('male', 'female', 'unspecified') NOT NULL DEFAULT 'unspecified',
    date_of_birth DATE NULL,
    address VARCHAR(255) NULL,
    specialty VARCHAR(120) NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX users_role_active_idx (role, is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS services (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    description VARCHAR(500) NOT NULL,
    duration_minutes SMALLINT UNSIGNED NOT NULL DEFAULT 30,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS appointments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    patient_id BIGINT UNSIGNED NOT NULL,
    doctor_id BIGINT UNSIGNED NULL,
    service_id BIGINT UNSIGNED NULL,
    scheduled_at DATETIME NOT NULL,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled', 'rejected') NOT NULL DEFAULT 'pending',
    reason VARCHAR(500) NOT NULL,
    diagnosis TEXT NULL,
    treatment TEXT NULL,
    admin_note VARCHAR(500) NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT appointments_patient_fk FOREIGN KEY (patient_id) REFERENCES users(id) ON DELETE RESTRICT,
    CONSTRAINT appointments_doctor_fk FOREIGN KEY (doctor_id) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT appointments_service_fk FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE SET NULL,
    INDEX appointments_patient_idx (patient_id, scheduled_at),
    INDEX appointments_doctor_idx (doctor_id, scheduled_at),
    INDEX appointments_status_idx (status, scheduled_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS contact_messages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL,
    phone VARCHAR(20) NULL,
    message TEXT NOT NULL,
    status ENUM('new', 'read', 'closed') NOT NULL DEFAULT 'new',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX contact_status_idx (status, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS audit_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    action VARCHAR(100) NOT NULL,
    entity_type VARCHAR(80) NULL,
    entity_id BIGINT UNSIGNED NULL,
    metadata JSON NULL,
    ip_address VARCHAR(45) NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT audit_user_fk FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX audit_user_created_idx (user_id, created_at),
    INDEX audit_entity_idx (entity_type, entity_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
