<?php


namespace App\lib\FS;


interface IFile
{
    public function getFilename(): ?string;

    public function setFilename(string $filename): self;

    public function getPath(): ?string;

    public function setPath(string $path): self;

    public function getFullPath(): ?string;

    public function setFullPath(string $fullPath): self;

    public function getSize(): ?int;

    public function setSize(int $size): self;

    public function getExtension(): ?string;

    public function setExtension(string $extension): self;
}