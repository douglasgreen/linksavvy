CREATE TABLE DomainNames (
  domainId int(11) NOT NULL AUTO_INCREMENT,
  domainName varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (domainId),
  UNIQUE KEY uniqueDomainName (domainName)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE Folders (
  folderId int(11) NOT NULL AUTO_INCREMENT,
  folderUserId int(11) NOT NULL,
  folderName varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  folderCreated timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (folderId),
  UNIQUE KEY UK_Folders_folderUserId_folderName (folderUserId,folderName),
  KEY FK_Folders_Users (folderUserId),
  CONSTRAINT FK_Folders_Users FOREIGN KEY (folderUserId) REFERENCES Users (userId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE Tags (
  tagId int(11) NOT NULL AUTO_INCREMENT,
  tagUserId int(11) NOT NULL,
  tagName varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  tagCreated timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (tagId),
  UNIQUE KEY UK_Tags_tagUserId_tagName (tagUserId,tagName),
  KEY FK_Tags_Users (tagUserId),
  CONSTRAINT FK_Tags_Users FOREIGN KEY (tagUserId) REFERENCES Users (userId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE UrlTags (
  urlId int(11) NOT NULL,
  tagId int(11) NOT NULL,
  PRIMARY KEY (urlId,tagId),
  KEY FK_UrlTags_Urls (urlId),
  KEY FK_UrlTags_Tags (tagId),
  CONSTRAINT FK_UrlTags_Tags FOREIGN KEY (tagId) REFERENCES Tags (tagId),
  CONSTRAINT FK_UrlTags_Urls FOREIGN KEY (urlId) REFERENCES Urls (urlId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE Urls (
  urlId int(11) NOT NULL AUTO_INCREMENT,
  folderId int(11) NOT NULL,
  originalUrl varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  urlTitle varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  urlDescription varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  domainId int(11) NOT NULL,
  visitCount int(11) NOT NULL DEFAULT '0',
  lastVisitDate timestamp NULL DEFAULT NULL,
  urlCreated timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (urlId),
  KEY FK_Urls_DomainNames (domainId),
  KEY FK_Urls_Folders (folderId),
  CONSTRAINT FK_Urls_DomainNames FOREIGN KEY (domainId) REFERENCES DomainNames (domainId),
  CONSTRAINT FK_Urls_Folders FOREIGN KEY (folderId) REFERENCES Folders (folderId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE Users (
  userId int(11) NOT NULL AUTO_INCREMENT,
  username varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  userPass char(255) COLLATE utf8_unicode_ci NOT NULL,
  userEmail varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  userCreated timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (userId),
  UNIQUE KEY uniqueUsername (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
