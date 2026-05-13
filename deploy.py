#!/usr/bin/env python3
"""
Deployment Script with Error Handling
Integrates error-config.py for comprehensive deployment management
"""

import sys
import os
import subprocess
import time
import logging
from error_config import (
    ERROR_CODES, ERROR_MESSAGES, RECOVERY_STRATEGIES,
    RETRY_POLICIES, HEALTH_CHECK_ENDPOINTS, LOGGING as LOG_CONFIG,
    ALERT_THRESHOLDS
)

# Configure logging
logging.basicConfig(
    level=getattr(logging, LOG_CONFIG['level']),
    format=LOG_CONFIG['format'],
    handlers=[
        logging.FileHandler(LOG_CONFIG['file']),
        logging.StreamHandler() if LOG_CONFIG['console'] else logging.NullHandler()
    ]
)
logger = logging.getLogger(__name__)


class DeploymentManager:
    """Main deployment manager with error recovery"""
    
    def __init__(self):
        self.errors = []
        self.recovery_attempted = False
        
    def execute_with_retry(self, command, error_key, policy_key):
        """Execute command with retry policy"""
        policy = RETRY_POLICIES.get(policy_key, {})
        max_retries = policy.get('max_retries', 3)
        backoff = policy.get('backoff_multiplier', 2)
        delay = policy.get('initial_delay', 5)
        
        for attempt in range(max_retries + 1):
            try:
                logger.info(f"Executing: {command} (Attempt {attempt + 1}/{max_retries + 1})")
                result = subprocess.run(command, shell=True, check=True, capture_output=True, text=True)
                logger.info(f"✅ Success: {command}")
                return True
            except subprocess.CalledProcessError as e:
                logger.error(f"❌ Failed: {command}\nError: {e.stderr}")
                
                if attempt < max_retries:
                    logger.warning(f"⏳ Retrying in {delay} seconds...")
                    time.sleep(delay)
                    delay *= backoff
                else:
                    self.handle_error(error_key)
                    return False
        return False
    
    def handle_error(self, error_key):
        """Handle error with recovery strategies"""
        error_info = ERROR_MESSAGES.get(error_key, {})
        logger.error(f"\n{'='*60}")
        logger.error(f"ERROR CODE: {ERROR_CODES.get(error_key, 'UNKNOWN')}")
        logger.error(f"MESSAGE: {error_info.get('message', 'Unknown error')}")
        logger.error(f"ACTION: {error_info.get('action', 'Check logs')}")
        logger.error(f"SEVERITY: {error_info.get('severity', 'UNKNOWN')}")
        logger.error(f"{'='*60}\n")
        
        self.errors.append(error_key)
        
        # Attempt recovery
        if not self.recovery_attempted:
            recovery_steps = RECOVERY_STRATEGIES.get(error_key, [])
            if recovery_steps:
                logger.info(f"🔧 Attempting recovery for {error_key}...")
                for step in recovery_steps:
                    logger.info(f"   → {step}")
                self.recovery_attempted = True
    
    def deploy(self):
        """Execute deployment pipeline"""
        logger.info("🚀 Starting deployment process...")
        
        # 1. Install PHP dependencies
        logger.info("\n📦 Step 1: Installing PHP dependencies...")
        if not self.execute_with_retry(
            'composer install --no-dev --optimize-autoloader',
            'COMPOSER_INSTALL_FAILED',
            'composer_install'
        ):
            return False
        
        # 2. Install NPM dependencies
        logger.info("\n📦 Step 2: Installing NPM dependencies...")
        if not self.execute_with_retry(
            'npm install',
            'NPM_INSTALL_FAILED',
            'npm_install'
        ):
            return False
        
        # 3. Build frontend assets
        logger.info("\n🏗️  Step 3: Building frontend assets...")
        if not self.execute_with_retry(
            'npm run build',
            'NPM_BUILD_FAILED',
            'npm_install'
        ):
            logger.warning("⚠️  Frontend build skipped (non-critical)")
        
        # 4. Setup directories
        logger.info("\n📁 Step 4: Setting up directories...")
        try:
            os.makedirs('storage/logs', exist_ok=True)
            os.makedirs('bootstrap/cache', exist_ok=True)
            os.system('chmod -R 775 storage bootstrap/cache')
            logger.info("✅ Directories configured")
        except Exception as e:
            self.handle_error('PERMISSION_DENIED')
            return False
        
        # 5. Database migration
        logger.info("\n🗄️  Step 5: Running database migrations...")
        if not self.execute_with_retry(
            'php artisan migrate --force',
            'MIGRATION_FAILED',
            'database_migration'
        ):
            return False
        
        # 6. Cache configuration
        logger.info("\n⚙️  Step 6: Caching configuration...")
        if not self.execute_with_retry(
            'php artisan config:cache',
            'CONFIG_CACHE_FAILED',
            'composer_install'
        ):
            logger.warning("⚠️  Config cache failed (continuing)")
        
        logger.info("\n✅ Deployment completed successfully!")
        return True
    
    def health_check(self):
        """Verify deployment health"""
        logger.info("\n🏥 Performing health checks...")
        
        for i, endpoint in enumerate(HEALTH_CHECK_ENDPOINTS, 1):
            url = endpoint.get('url')
            method = endpoint.get('method', 'GET')
            timeout = endpoint.get('timeout', 10)
            
            logger.info(f"  [{i}] Checking {method} {url}...")
            
            if method == 'GET':
                try:
                    result = subprocess.run(
                        f'curl -s -m {timeout} {url}',
                        shell=True, capture_output=True, text=True
                    )
                    if result.returncode == 0:
                        logger.info(f"      ✅ Health check passed")
                    else:
                        logger.warning(f"      ⚠️  Health check failed")
                except Exception as e:
                    logger.error(f"      ❌ Error: {e}")
            
            elif method == 'TCP':
                try:
                    host, port = url.split(':')
                    result = subprocess.run(
                        f'timeout {timeout} bash -c "echo > /dev/tcp/{host}/{port}"',
                        shell=True, capture_output=True
                    )
                    if result.returncode == 0:
                        logger.info(f"      ✅ TCP connection successful")
                    else:
                        logger.warning(f"      ⚠️  TCP connection failed")
                except Exception as e:
                    logger.error(f"      ❌ Error: {e}")
    
    def get_summary(self):
        """Get deployment summary"""
        summary = f"""
{'='*60}
DEPLOYMENT SUMMARY
{'='*60}
Status: {'✅ SUCCESS' if not self.errors else '❌ FAILED'}
Errors Encountered: {len(self.errors)}
"""
        if self.errors:
            summary += "\nErrors:\n"
            for error in self.errors:
                summary += f"  - {error} (Code: {ERROR_CODES.get(error, 'UNKNOWN')})\n"
        
        summary += f"{'='*60}\n"
        return summary


def main():
    """Main entry point"""
    manager = DeploymentManager()
    
    try:
        # Execute deployment
        success = manager.deploy()
        
        # Health check
        if success:
            manager.health_check()
        
        # Print summary
        logger.info(manager.get_summary())
        
        return 0 if success else 1
    
    except KeyboardInterrupt:
        logger.error("❌ Deployment interrupted by user")
        return 130
    except Exception as e:
        logger.error(f"❌ Unexpected error: {e}")
        return 1


if __name__ == '__main__':
    sys.exit(main())
