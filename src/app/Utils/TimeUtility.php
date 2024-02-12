<?php

namespace App\Utils;

use App\Models\{
    BusinessDate
};
use DateTime;
use Illuminate\Support\{
    Carbon,
};

class TimeUtility
{
    /**
     * 受け取った文字列を営業日を元にCarbon型へ変換
     * 営業日：2023/12/24
     * 文字列：25:00
     * 　→　2023/12/25 01:00
     * @param BusinessDate $businessDate
     * @param ?string $hh hh
     * @param ?string $mm mm
     */
    public static function caluculateDateTime(BusinessDate $businessDate, ?string $hh, ?string $mm): ?Carbon
    {
        if (is_null($hh)) {
            return null;
        }

        // 営業日をCarbonオブジェクトに変換
        $businessDateCarbon = Carbon::createFromFormat('Y-m-d', $businessDate->business_date);

        // ":" を区切り文字として分割し、時刻の各部分を取得
        // $timeParts = explode(":", $time);
        $hh = intval($hh); // 数値に変換

        // "25:00" のような時間が与えられた場合、24時を超えているので日にちを追加
        if ($hh >= 24) {
            $additionalDays = floor($hh / 24); // 24時間ごとの追加日数
            $additionalHours = $hh % 24; // 24時間を超えた部分の時間

            // 営業日に日数を追加
            $businessDateCarbon->addDays($additionalDays);

            // 時間を追加
            $businessDateCarbon->setHour($additionalHours);
        } else {
            // 24時未満の場合、そのまま時刻を設定
            $businessDateCarbon->setHour($hh);
        }

        // 分の部分を設定（"mm" が提供される場合は必要に応じて設定）
        if (isset($mm)) {
            $mm = intval($mm); // 数値に変換
            $businessDateCarbon->setMinute($mm);
        } else {
            $businessDateCarbon->setMinute(0);
        }

        $businessDateCarbon->setSecond(0);

        return $businessDateCarbon;
    }

    /**
     * 営業日付と日時から営業日付を基準とした36h表記へ変換する
     * @param BusinessDate $businessDate
     * @param string $dateTimeString
     * @return string
     */
    public static function adjustTo36HoursFormat(BusinessDate $businessDate, string $dateTimeString)
    {
        $businessDateCarbon = Carbon::createFromFormat('Y-m-d', $businessDate->business_date);
        $dateTimeCarbon = Carbon::parse($dateTimeString);

        // 同じ日付の場合はそのままの時刻を文字列として返す
        if ($businessDateCarbon->isSameDay($dateTimeCarbon)) {
            return $dateTimeCarbon->format('H:i'); // 'H:i' は時と分を意味します
        }

        // 異なる日付の場合、時刻に24時間を加算して36時間形式に調整する
        $adjustedHour = $dateTimeCarbon->hour + 24;
        $formattedMinute = str_pad($dateTimeCarbon->minute, 2, '0', STR_PAD_LEFT);

        return $adjustedHour . ':' . $formattedMinute;
    }

    /**
     * 営業日付と日時から営業日付を基準とした36h表記へ変換したHHを取得する
     * @param BusinessDate $businessDate
     * @param string $dateTimeString
     * @return string
     */
    public static function getBusinessDateBasedHour36hFormat(BusinessDate $businessDate, string $dateTimeString)
    {
        // 営業日と$workingStartAtの年月日が同じ場合
        $carbonBusinessDate = Carbon::parse($businessDate->business_date);
        $carbonDateTimeString = Carbon::parse($dateTimeString);

        if ($carbonBusinessDate->isSameDay($carbonDateTimeString)) {
            return (int) date('H', strtotime($dateTimeString));
        }

        // 別日の場合
        $dateTimeStringHour = (int) date('H', strtotime($dateTimeString));
        $dateTimeStringHour += 24;
        return $dateTimeStringHour;
    }
}
