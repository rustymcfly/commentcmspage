<?php declare(strict_types=1);

namespace RustyMcFly\CommentCmsPage\Core\Content\Comment;

use Shopware\Core\Content\Category\CategoryEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use Shopware\Core\System\SalesChannel\SalesChannelEntity;

class CommentEntity extends Entity
{
    use EntityIdTrait;

    public function __construct()
    {
        $this->children = new CommentCollection();
    }

    protected ?string $email;
    protected ?string $email_verify_token;
    protected ?\DateTime $email_verified_at;
    protected ?string $text;
    protected ?string $firstName;
    protected ?string $lastName;
    protected bool $active;

    protected ?string $categoryId;
    protected ?CategoryEntity $category;

    protected ?string $salesChannelId;
    protected ?SalesChannelEntity $salesChannel;

    protected ?CommentCollection $children;

    protected ?string $parentId;
    protected ?CommentEntity $parent;

    public function getChildren(): ?CommentCollection
    {
        return $this->children;
    }

    public function setChildren(?CommentCollection $children): void
    {
        $this->children = $children;
    }

    public function getParent(): ?CommentEntity
    {
        return $this->parent;
    }

    public function setParent(?CommentEntity $parent): void
    {
        $this->parent = $parent;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getEmailVerifyToken(): ?string
    {
        return $this->email_verify_token;
    }

    public function setEmailVerifyToken(?string $email_verify_token): void
    {
        $this->email_verify_token = $email_verify_token;
    }

    public function getEmailVerifiedAt(): ?\DateTime
    {
        return $this->email_verified_at;
    }

    public function setEmailVerifiedAt(?\DateTime $email_verified_at): void
    {
        $this->email_verified_at = $email_verified_at;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getCategoryId(): ?string
    {
        return $this->categoryId;
    }

    public function setCategoryId(?string $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function getCategory(): ?CategoryEntity
    {
        return $this->category;
    }

    public function setCategory(?CategoryEntity $category): void
    {
        $this->category = $category;
    }

    public function getSalesChannelId(): ?string
    {
        return $this->salesChannelId;
    }

    public function setSalesChannelId(?string $salesChannelId): void
    {
        $this->salesChannelId = $salesChannelId;
    }

    public function getSalesChannel(): ?SalesChannelEntity
    {
        return $this->salesChannel;
    }

    public function setSalesChannel(?SalesChannelEntity $salesChannel): void
    {
        $this->salesChannel = $salesChannel;
    }

    public function getParentId(): ?string
    {
        return $this->parentId;
    }

    public function setParentId(?string $parentId): void
    {
        $this->parentId = $parentId;
    }


}
