CREATE TABLE review(
  `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  `score` INTEGER NOT NULL CHECK (`score` BETWEEN 1 AND 10),
  `status` INTEGER NOT NULL CHECK (`status` BETWEEN 0 AND 1),
  `user_exist` INTEGER NOT NULL CHECK (`user_exist` BETWEEN 0 AND 1)
);

CREATE TABLE article_review(
  `article_id` INTEGER NOT NULL,
  `review_id` INTEGER NOT NULL,
  `status` INTEGER NOT NULL CHECK (`status` BETWEEN 0 AND 1),
  PRIMARY KEY (article_id,review_id),
  FOREIGN KEY (article_id) REFERENCES article(id),
  FOREIGN KEY (review_id) REFERENCES review(id)
);

CREATE TABLE user_review(
  `user_id` INTEGER NOT NULL,
  `review_id` INTEGER NOT NULL,
  `status` INTEGER NOT NULL CHECK (`status` BETWEEN 0 AND 1),
  PRIMARY KEY (user_id,review_id),
  FOREIGN KEY (user_id) REFERENCES user(id),
  FOREIGN KEY (review_id) REFERENCES review(id)
);

ALTER TABLE 'user_review' RENAME TO 'user-review';
ALTER TABLE "article_review" RENAME TO "article-review";

DROP TABLE review;
DROP TABLE "article-review";
DROP TABLE "user-review";

CREATE TABLE review (
  `id`      INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  `score`   INTEGER NOT NULL CHECK (`score` BETWEEN 1 AND 10),
  `status`  INTEGER NOT NULL CHECK (`status` BETWEEN 0 AND 1),
  `user_id` INTEGER REFERENCES user (id)
);

CREATE TABLE 'article-review'(
  `article_id` INTEGER NOT NULL REFERENCES article(id),
  `review_id` INTEGER NOT NULL REFERENCES review(id),
  `status` INTEGER NOT NULL CHECK (`status` BETWEEN 0 AND 1),
  constraint article_review PRIMARY KEY (article_id,review_id)
);

CREATE TABLE `user-review`(
  `user_id` INTEGER NOT NULL REFERENCES user(id),
  `review_id` INTEGER NOT NULL REFERENCES review(id),
  `status` INTEGER NOT NULL CHECK (`status` BETWEEN 0 AND 1),
  CONSTRAINT user_review PRIMARY KEY (user_id,review_id)
);
