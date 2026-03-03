-- Add category field to approval_flows table
ALTER TABLE `approval_flows` 
ADD COLUMN `category` ENUM('mengetahui', 'menyetujui') NOT NULL DEFAULT 'menyetujui' COMMENT 'Approval category type';
