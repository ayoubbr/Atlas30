
-- SELECT CONCAT(users.firstname, ' ', users.lastname) AS fullname, users.email, roles.name
-- FROM users 
-- JOIN roles ON roles.id = users.role_id;

-- SELECT games.id AS MATCHId , stadiums.name FROM games
-- JOIN stadiums ON stadiums.id = games.stadium_id;

-- SELECT COUNT(id) FROM tickets
-- WHERE tickets.status = 'sold';

-- SELECT games.id, games.start_date, COUNT(tickets.id) as tickets_count FROM games
-- JOIN tickets ON tickets.game_id = games.id 
-- GROUP BY (games.id) ORDER BY tickets_count DESC
-- LIMIT 1;

-- SELECT users.firstname, users.lastname, SUM(payments.amount) AS total_paid
-- FROM users
-- JOIN payments ON users.id = payments.user_id
-- GROUP BY users.id;


-- SELECT games.id, SUM(tickets.price) as summ
-- FROM games
-- JOIN tickets ON games.id = tickets.game_id
-- GROUP BY (games.id)
-- order by summ DESC
-- limit 1

-- SELECT users.firstname, users.lastname,   
-- 	   COUNT(DISTINCT posts.id) AS posts_count,
--        COUNT(DISTINCT comments.id) AS comments_count,
--        COUNT(DISTINCT posts.id) + COUNT(DISTINCT comments.id) AS total_activity
-- FROM users
-- LEFT JOIN posts ON users.id = posts.user_id
-- LEFT JOIN comments ON users.id = comments.user_id
-- group by users.id 
-- ORDER by total_activity desc
-- limit 3