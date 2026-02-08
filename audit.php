<?php
/**
 * Simple audit logging helper.
 *
 * Expected table (recommended):
 *   audit_logs(id INT AUTO_INCREMENT PRIMARY KEY,
 *              voter_id INT NULL,
 *              action VARCHAR(100) NOT NULL,
 *              details TEXT NULL,
 *              created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
 */
function audit_log(mysqli $conn, ?int $userId, string $action, string $details = ""): void
{
    $action = trim($action);
    if ($action === "") return;

    $details = trim($details);
    $uid = $userId ?? 0;

    // Try common schemas: voter_id may allow NULL, but binding NULL in mysqli can be tricky.
    // We'll store 0 when unknown.
    $stmt = $conn->prepare("INSERT INTO audit_logs (voter_id, action, details) VALUES (?, ?, ?)");
    if (!$stmt) return;

    $stmt->bind_param("iss", $uid, $action, $details);
    $stmt->execute();
    $stmt->close();
}

function audit_client_details(): string
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown-ip';
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown-ua';
    return "IP: {$ip} | UA: {$ua}";
}
