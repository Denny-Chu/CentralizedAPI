<?php

namespace App\Http\Services;

class LottoService extends Service
{
    /**
     * 越南彩Url params轉換
     * - LOTTO 層級為 agent(platform) > operator(agent)
     */
    public static function transParams($params, $apiKey)
    {
        $agentId = $params['platform'];
        $operatorId = $params['agentName'];
        $memId = $params['username'];
        // 調整Params
        $params['agentId'] = $agentId;
        $params['operatorId'] = $operatorId;
        $params['memId'] = $memId;
        $params['api_key'] = $apiKey;
        $params['hash'] = self::getLottoHash($agentId, $apiKey);

        return $params;
    }

    /**
     * 越南彩route轉換
     */
    public static function getLottoRoute($url)
    {
        $lottoUrlList = [
            // auth
            'login' => 'login', // 玩家登入
            'logout' => 'logout-member', // 玩家登出
            'logout/all' => 'logout-all', // 玩家全體登出
            // agent
            'agents' => 'agent/create', // 創建代理
            // player
            'players' => 'siginUp', // 建立玩家
            'players/status' => 'member-status', // 玩家狀態
            // transaction
            'transfer' => 'transfer', // 轉帳
            'history/transfer' => 'report/player-transfer', // 轉帳紀錄
            // game
            'history/transaction' => 'report/player-record-summary', // 投注紀錄摘要紀錄
            'history/detail/order' => 'report/player-record', //投注紀錄
        ];

        return $lottoUrlList[$url];
    }

    /**
     * 建立越南彩hash
     */
    public static function getLottoHash($agentId, $apiKey)
    {
        $md5Hash = md5($agentId . $apiKey);
        $encryptedString = hash('sha256', $md5Hash);

        return $encryptedString;
    }
}
