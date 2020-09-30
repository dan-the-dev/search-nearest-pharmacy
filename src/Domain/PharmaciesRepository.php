<?php

namespace Domain;

interface PharmaciesRepository
{
    /**
     * @return array<Pharmacy>
     */
    public function getAllPharmacies(): array;
}