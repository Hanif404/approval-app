-- Add user selection field to approval_flows table
ALTER TABLE `approval_flows` 
ADD COLUMN `user_id` INT NULL COMMENT 'Specific user assigned to this approval step',
ADD CONSTRAINT `fk_approval_flows_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL;
