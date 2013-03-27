SELECT t.OrderItemId AS t0_c0, t.ProductId AS t0_c1, t.PayerId AS t0_c2, t.OwnerId AS t0_c3, t.RedirectId AS t0_c4, t.CouponActivatedId AS t0_c5, t.Booked AS t0_c6, t.Paid AS t0_c7, t.PaidTime AS t0_c8, t.CreationTime AS t0_c9, t.Deleted AS t0_c10, Product.ProductId AS t1_c0, Product.Manager AS t1_c1, Product.Title AS t1_c2, Product.Description AS t1_c3, Product.EventId AS t1_c4, Product.Unit AS t1_c5, Product.Count AS t1_c6, Product.EnableCoupon AS t1_c7, Orders.OrderId AS t2_c0, Orders.PayerId AS t2_c1, Orders.EventId AS t2_c2, Orders.CreationTime AS t2_c3, OrderJuridical.OrderJuricalId AS t3_c0, OrderJuridical.OrderId AS t3_c1, OrderJuridical.Name AS t3_c2, OrderJuridical.Address AS t3_c3, OrderJuridical.INN AS t3_c4, OrderJuridical.KPP AS t3_c5, OrderJuridical.Phone AS t3_c6, OrderJuridical.Fax AS t3_c7, OrderJuridical.PostAddress AS t3_c8, OrderJuridical.Paid AS t3_c9, OrderJuridical.Deleted AS t3_c10 FROM Mod_PayOrderItem t


LEFT OUTER JOIN Mod_PayProduct Product ON (t.ProductId=Product.ProductId)


LEFT OUTER JOIN Mod_PayOrderItemLink Orders_Orders ON (t.OrderItemId=Orders_Orders.OrderItemId)

LEFT OUTER JOIN Mod_PayOrder Orders ON (Orders.OrderId=Orders_Orders.OrderId)


LEFT OUTER JOIN Mod_PayOrderJuridical OrderJuridical ON (OrderJuridical.OrderId=Orders.OrderId) AND (OrderJuridical.Paid = 1) WHERE ((Product.EventId = :EventId) AND (t.Paid = :Paid))