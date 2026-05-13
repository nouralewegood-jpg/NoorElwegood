# Error Handling Configuration
# This file contains all error messages and handling strategies

ERROR_CODES = {
    'COMPOSER_INSTALL_FAILED': 1001,
    'NPM_INSTALL_FAILED': 1002,
    'NPM_BUILD_FAILED': 1003,
    'DATABASE_CONNECTION_FAILED': 2001,
    'MIGRATION_FAILED': 2002,
    'CONFIG_CACHE_FAILED': 3001,
    'PERMISSION_DENIED': 4001,
    'DIRECTORY_NOT_FOUND': 4002,
    'FILE_NOT_FOUND': 4003,
    'DISK_SPACE_LOW': 5001,
    'TIMEOUT': 6001,
    'UNKNOWN_ERROR': 9999,
}

ERROR_MESSAGES = {
    'COMPOSER_INSTALL_FAILED': {
        'message': 'Failed to install PHP dependencies via Composer',
        'action': 'Run: composer install --no-dev',
        'severity': 'CRITICAL'
    },
    'NPM_INSTALL_FAILED': {
        'message': 'Failed to install JavaScript dependencies via npm',
        'action': 'Run: npm install',
        'severity': 'CRITICAL'
    },
    'NPM_BUILD_FAILED': {
        'message': 'Failed to build frontend assets',
        'action': 'Run: npm run build',
        'severity': 'WARNING'
    },
    'DATABASE_CONNECTION_FAILED': {
        'message': 'Could not connect to PostgreSQL database',
        'action': 'Ensure PostgreSQL is running and credentials are correct',
        'severity': 'CRITICAL'
    },
    'MIGRATION_FAILED': {
        'message': 'Database migration process failed',
        'action': 'Run: php artisan migrate --force',
        'severity': 'CRITICAL'
    },
    'CONFIG_CACHE_FAILED': {
        'message': 'Failed to cache configuration',
        'action': 'Run: php artisan config:cache',
        'severity': 'WARNING'
    },
    'PERMISSION_DENIED': {
        'message': 'Permission denied on critical directory',
        'action': 'Run: chmod -R 775 storage bootstrap/cache',
        'severity': 'CRITICAL'
    },
    'DIRECTORY_NOT_FOUND': {
        'message': 'Critical directory not found',
        'action': 'Ensure project structure is intact',
        'severity': 'CRITICAL'
    },
    'FILE_NOT_FOUND': {
        'message': 'Critical file not found',
        'action': 'Check project files are in place',
        'severity': 'CRITICAL'
    },
    'DISK_SPACE_LOW': {
        'message': 'Low disk space available',
        'action': 'Free up disk space or expand storage',
        'severity': 'WARNING'
    },
    'TIMEOUT': {
        'message': 'Operation timed out',
        'action': 'Increase timeout value or check system resources',
        'severity': 'WARNING'
    },
    'UNKNOWN_ERROR': {
        'message': 'An unknown error occurred',
        'action': 'Check logs for more information',
        'severity': 'CRITICAL'
    },
}

# Recovery strategies
RECOVERY_STRATEGIES = {
    'COMPOSER_INSTALL_FAILED': [
        'Clear composer cache: composer clear-cache',
        'Update composer: composer update',
        'Remove vendor directory: rm -rf vendor',
        'Retry install: composer install'
    ],
    'DATABASE_CONNECTION_FAILED': [
        'Check PostgreSQL service: systemctl status postgresql',
        'Verify connection string in .env',
        'Check database credentials',
        'Restart PostgreSQL service'
    ],
    'MIGRATION_FAILED': [
        'Rollback migrations: php artisan migrate:rollback',
        'Check migration files for syntax errors',
        'Verify database connection',
        'Retry migration: php artisan migrate'
    ],
    'PERMISSION_DENIED': [
        'Run: sudo chown -R $USER:$USER .',
        'Set permissions: chmod -R 775 storage bootstrap/cache',
        'Verify current user can write to directories'
    ],
}

# Retry policies
RETRY_POLICIES = {
    'composer_install': {
        'max_retries': 3,
        'backoff_multiplier': 2,
        'initial_delay': 5
    },
    'npm_install': {
        'max_retries': 3,
        'backoff_multiplier': 2,
        'initial_delay': 5
    },
    'database_migration': {
        'max_retries': 2,
        'backoff_multiplier': 3,
        'initial_delay': 10
    },
    'health_check': {
        'max_retries': 30,
        'backoff_multiplier': 1,
        'initial_delay': 2
    }
}

# Health check endpoints
HEALTH_CHECK_ENDPOINTS = [
    {
        'url': 'http://localhost:10000/health',
        'method': 'GET',
        'timeout': 10,
        'expected_status': 200
    },
    {
        'url': 'http://localhost:5432',
        'method': 'TCP',
        'timeout': 5
    }
]

# Logging configuration
LOGGING = {
    'level': 'INFO',
    'format': '[%(asctime)s] %(levelname)s: %(message)s',
    'file': '/var/www/html/logs/error.log',
    'max_size': '100M',
    'backup_count': 10,
    'console': True
}

# Alert thresholds
ALERT_THRESHOLDS = {
    'cpu_usage': 80,
    'memory_usage': 85,
    'disk_usage': 90,
    'response_time': 5000,  # milliseconds
}
