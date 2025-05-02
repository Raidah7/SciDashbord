<?php

// app/Constants/DocumentType.php
namespace App\Constants;

class DocumentType
{
    const FAMILY_RECORD = 'family_record';
    const BASIC_ENHANCEMENTS = 'basic_enhancements';
    const BIRTH_CERTIFICATE = 'birth_certificate';
    const RENT_CONTRACT = 'rent_contract';

    /**
     * الحصول على جميع أنواع المستندات كمصفوفة.
     */
    public static function all(): array
    {
        return [
            self::FAMILY_RECORD,
            self::BASIC_ENHANCEMENTS,
            self::BIRTH_CERTIFICATE,
            self::RENT_CONTRACT,
        ];
    }

    /**
     * الحصول على التسمية المقروءة لكل نوع.
     */
    public static function getLabel(string $type): string
    {
        $labels = [
            self::FAMILY_RECORD => 'سجل الأسرة/الإقامة',
            self::BASIC_ENHANCEMENTS => 'التحسينات الأساسية',
            self::BIRTH_CERTIFICATE => 'شهادة الميلاد',
            self::RENT_CONTRACT => 'عقد الإيجار/ملكية السكن',
        ];

        return $labels[$type] ?? 'نوع غير معروف';
    }
}
