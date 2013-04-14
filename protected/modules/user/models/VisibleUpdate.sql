UPDATE "User" as u SET "Visible" = us."Visible"

FROM "UserSettings" as us

WHERE u."Id" = us."UserId"