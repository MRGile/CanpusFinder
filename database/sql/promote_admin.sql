START TRANSACTION;

UPDATE users
SET role = 'admin'
WHERE email = 'ganti-dengan-email-akun@example.com';

SELECT id, name, email, role
FROM users
WHERE email = 'ganti-dengan-email-akun@example.com';

COMMIT;
