-- FastFreela schema (MySQL / InnoDB / utf8mb4)

CREATE TABLE IF NOT EXISTS users (
  id            BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name          VARCHAR(120) NOT NULL,
  email         VARCHAR(180) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  primary_role  ENUM('CONTRACTOR','WORKER') NOT NULL,
  is_admin      TINYINT(1) NOT NULL DEFAULT 0,
  bio           TEXT NULL,
  created_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at    DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS jobs (
  id               BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  author_id        BIGINT UNSIGNED NOT NULL,
  title            VARCHAR(140) NOT NULL,
  description      TEXT NOT NULL,
  job_date         DATE NOT NULL,
  estimated_value  DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  hiring_details   TEXT NULL,
  status           ENUM('OPEN','CLOSED') NOT NULL DEFAULT 'OPEN',
  created_at       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at       DATETIME NULL,
  CONSTRAINT fk_jobs_author FOREIGN KEY (author_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE INDEX idx_jobs_title ON jobs(title);
CREATE INDEX idx_jobs_status ON jobs(status);

CREATE TABLE IF NOT EXISTS job_favorites (
  user_id BIGINT UNSIGNED NOT NULL,
  job_id  BIGINT UNSIGNED NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id, job_id),
  CONSTRAINT fk_fav_user FOREIGN KEY (user_id) REFERENCES users(id),
  CONSTRAINT fk_fav_job  FOREIGN KEY (job_id) REFERENCES jobs(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS job_comments (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  job_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL,
  content TEXT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  deleted_at DATETIME NULL,
  CONSTRAINT fk_comments_job FOREIGN KEY (job_id) REFERENCES jobs(id),
  CONSTRAINT fk_comments_user FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE INDEX idx_comments_job_created ON job_comments(job_id, created_at);
