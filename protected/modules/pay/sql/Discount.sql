DELIMITER $$

DROP FUNCTION IF EXISTS `Discount`;

CREATE FUNCTION `Discount` (OrderItemId INT, UserId INT, ProductId INT)
LANGUAGE SQL
DETERMINISTIC
SQL SECURITY DEFINER
BEGIN
  DECLARE done, EventId INT;
  DECLARE activatedCoupons CURSOR FOR SELECT * FROM Mod_PayCouponActivated ;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

  SET done 0 1;
  SELECT EventId INTO EventId FROM Mod_PayProduct WHERE Mod_PayProduct.ProductId = ProductId;

  RETURN EventId;

END;


