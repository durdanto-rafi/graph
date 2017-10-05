<?php
namespace App\Libraries\Tb;
class TbEntry extends TbMap
{
    protected $binary = '';

    protected function entry($binary)
    {

        if( '' === $binary ){ throw new Exception('ファイルを確認できません。'.__LINE__); }

        $this->binary = $binary;

        //シンクボードヘッダ(10byte)
        $this->thinkBoardHeaderIndex = 0;
        $this->thinkBoardHeaderLength = 10;

        // ThinkBoardファイルチェック
        if( "ThinkBoard" !== substr($this->binary, $this->thinkBoardHeaderIndex, $this->thinkBoardHeaderLength)){
            throw new Exception('ThinkBoardファイルではありません。'.__LINE__);
        }

        //制作エディションヘッダ(2byte)
        $this->editionHeaderIndex = 10;
        $this->editionHeaderLength = 2;

        //プレーヤー識別ヘッダ(3byte)
        $this->playerHeaderIndex = 12;
        $this->playerHeaderLength = 3;

        //コンテンツ識別ヘッダ(3byte)
        $this->contentsHeaderIndex = 15;
        $this->contentsHeaderLength = 3;

        if('TAP' === substr($this->binary,$this->playerHeaderIndex,$this->playerHeaderLength)){
            if('TAD' === substr( $this->binary, $this->contentsHeaderIndex, $this->contentsHeaderLength)){
                throw new Exception('会員用コンテンツは使用できません。'.__LINE__);
            }
        }

        //ヘルプ用メッセージの言語識別データサイズ(4byte)
        $this->helpMessageSizeIndex = 18;
        $this->helpMessageSizeLength = 4;

        //ヘルプ用メッセージの言語識別データ
        $this->helpMessageDataIndex = 22;
        $arr = unpack( 'V', substr( $this->binary, $this->helpMessageSizeIndex, $this->helpMessageSizeLength ) );
        $this->helpMessageDataLength = $arr[ 1 ];

        //自動終了データサイズ(4byte)
        $this->autoEndSizeIndex = $this->helpMessageDataIndex + $this->helpMessageDataLength;
        $this->autoEndSizeLength = 4;

        //自動終了データ
        $this->autoEndDataIndex = $this->autoEndSizeIndex + $this->autoEndSizeLength;
        $arr = unpack( 'V', substr( $this->binary, $this->autoEndSizeIndex, $this->autoEndSizeLength ) );
        $this->autoEndDataLength = $arr[ 1 ];

        //参照URL データサイズ(4byte)
        $this->urlSizeIndex = $this->autoEndDataIndex + $this->autoEndDataLength;
        $this->urlSizeLength = 4;

        //参照URLデータ
        $this->urlDataIndex = $this->urlSizeIndex + $this->urlSizeLength;
        $arr = unpack( 'V', substr( $this->binary, $this->urlSizeIndex, $this->urlSizeLength ) );
        $this->urlDataLength = $arr[ 1 ];

        //PCLPM データサイズ（4byte 未使用）
        $this->pclpmSizeIndex = $this->urlDataIndex + $this->urlDataLength;
        $this->pclpmSizeLength = 4;

        //PCLPMデータ（未使用）
        $this->pclpmDataIndex = $this->pclpmSizeIndex + $this->pclpmSizeLength;
        $arr = unpack( 'V', substr( $this->binary, $this->pclpmSizeIndex, $this->pclpmSizeLength ) );
        $this->pclpmDataLength = $arr[ 1 ];

        //英語版ヘルプ用メッセージデータサイズ(4byte)
        $this->engHelpSizeIndex = $this->pclpmDataIndex + $this->pclpmDataLength;
        $this->engHelpSizeLength = 4;

        //英語版ヘルプ用メッセージデータ
        $this->engHelpDataIndex = $this->engHelpSizeIndex + $this->engHelpSizeLength;
        $arr = unpack( 'V', substr( $this->binary, $this->engHelpSizeIndex, $this->engHelpSizeLength ) );
        $this->engHelpDataLength = $arr[ 1 ];

        //日本語版ヘルプ用メッセージデータサイズ(4byte)
        $this->jpnHelpSizeIndex = $this->engHelpDataIndex + $this->engHelpDataLength;
        $this->jpnHelpSizeLength = 4;

        //日本語版ヘルプ用メッセージデータ
        $this->jpnHelpDataIndex = $this->jpnHelpSizeIndex + $this->jpnHelpSizeLength;
        $arr = unpack( 'V', substr( $this->binary, $this->jpnHelpSizeIndex, $this->jpnHelpSizeLength ) );
        $this->jpnHelpDataLength = $arr[ 1 ];

        //マイルストン
        $milestone = $this->jpnHelpDataIndex + $this->jpnHelpDataLength;

        // 制作エディションヘッダが、'04' 又は、'05' の時のみ、lpf と qsf が存在します。(※制作エディションヘッダは文字列で格納してました。)
        switch(substr($this->binary, $this->editionHeaderIndex, $this->editionHeaderLength)){
            case '04':
            case '05':{
                //lpfヘッダ（連続再生フラグ用の目印）
                $this->lpfHeaderIndex = $milestone;
                $this->lpfHeaderLength = 3;

                //連続再生フラグ
                $this->loopIndex = $this->lpfHeaderIndex + $this->lpfHeaderLength;
                $this->loopLength = 1;

                $hex = bin2hex(substr($this->binary, $this->loopIndex, $this->loopLength));

                if ('00' === $hex) { $this->flgloop = true; }

                //qsfヘッダ（倍速再生フラグ用の目印）
                $this->qsfHeaderIndex = $this->loopIndex + $this->loopLength;
                $this->qsfHeaderLength = 3;

                //倍速再生フラグ
                $this->baisokuIndex = $this->qsfHeaderIndex + $this->qsfHeaderLength;
                $this->baisokuLength = 1;

                $hex = bin2hex(substr($this->binary, $this->baisokuIndex, $this->baisokuLength));

                if ('00' === $hex) { $this->flgBaisoku = true; }

                //マイルストン
                $milestone = $this->baisokuIndex + $this->baisokuLength;
                break;
            }
        }

        //pcgヘッダ（最終画面画像データの目印）
        $this->pcgHeaderIndex = $milestone;
        $this->pcgHeaderLength = 3;

        //最終画面画像データフラグ(1バイト : 0 = あり/FF = なし)
        $this->finalScreenIndex = $this->pcgHeaderIndex + $this->pcgHeaderLength;
        $this->finalScreenLength = 1;
        $hex = bin2hex( substr( $this->binary, $this->finalScreenIndex, $this->finalScreenLength ) );

        if ('00' === $hex){ $this->flgFinalScreen = true; }

        //マイルストン
        $milestone = $this->finalScreenIndex + $this->finalScreenLength;

        if( true === $this->flgFinalScreen ){
            //画像ファイルサイズ(4byte)
            $this->finalScreenSizeIndex = $milestone;
            $this->finalScreenSizeLength = 4;

            //画像ファイルデータ
            $this->finalScreenDataIndex = $this->finalScreenSizeIndex + $this->finalScreenSizeLength;
            $arr = unpack( 'V', substr( $this->binary, $this->finalScreenSizeIndex, $this->finalScreenSizeLength ) );
            $this->finalScreenDataLength = $arr[ 1 ];

            //マイルストン
            $milestone = $this->finalScreenDataIndex + $this->finalScreenDataLength;
        }

        //ulc ヘッダ 3 バイト(参照 URL 表示色の目印)
        $this->ulcHeaderIndex = $milestone;
        $this->ulcHeaderLength = 3;

        //参照URL表示色データサイズ(4byte)
        $this->urlColorSizeIndex = $this->ulcHeaderIndex + $this->ulcHeaderLength;
        $this->urlColorSizeLength = 4;

        //参照URL表示色データ
        $this->urlColorDataIndex = $this->urlColorSizeIndex + $this->urlColorSizeLength;
        $arr = unpack( 'V', substr( $this->binary, $this->urlColorSizeIndex, $this->urlColorSizeLength ) );
        $this->urlColorDataLength = $arr[ 1 ];

        //ppwヘッダ(パスワードの目印)
        $this->ppwHeaderIndex = $this->urlColorDataIndex + $this->urlColorDataLength;
        $this->ppwHeaderLength = 3;

        //パスワードデータサイズ (4byte)
        $this->passwordSizeIndex = $this->ppwHeaderIndex + $this->ppwHeaderLength;
        $this->passwordSizeLength = 4;

        //パスワードデータ
        $this->passwordDataIndex = $this->passwordSizeIndex + $this->passwordSizeLength;
        $arr = unpack( 'V', substr( $this->binary, $this->passwordSizeIndex, $this->passwordSizeLength ) );
        $this->passwordDataLength = $arr[ 1 ];

        //ld0ヘッダ(開始日？の目印)
        $this->ld0HeaderIndex = $this->passwordSizeIndex + $this->passwordSizeLength;
        $this->ld0HeaderLength = 3;

        //不明データ データサイズ (4byte)
        $this->unknownSizeIndex = $this->ld0HeaderIndex + $this->ld0HeaderLength;
        $this->unknownSizeLength = 4;

        //不明データ
        $this->unknownDataIndex = $this->unknownSizeIndex + $this->unknownSizeLength;
        $arr = unpack( 'V', substr( $this->binary, $this->unknownSizeIndex, $this->unknownSizeLength ) );
        $this->unknownDataLength = $arr[ 1 ];

        //ld1ヘッダ(開始日と終了日？の目印)
        $this->ld1HeaderIndex = $this->unknownDataIndex + $this->unknownDataLength;
        $this->ld1HeaderLength = 3;

        //開始日と終了日 データサイズ
        $this->startAndEndDateSizeIndex = $this->ld1HeaderIndex + $this->ld1HeaderLength;
        $this->startAndEndDateSizeLength = 4;

        // 開始日と終了日 データ
        $this->startAndEndDateDataIndex = $this->startAndEndDateSizeIndex + $this->startAndEndDateSizeLength;
        $arr = unpack( 'V', substr( $this->binary, $this->startAndEndDateSizeIndex, $this->startAndEndDateSizeLength ) );
        $this->startAndEndDateDataLength = $arr[ 1 ];

        //clヘッダ(チャプターの目印)
        $this->clHeaderIndex = $this->startAndEndDateDataIndex + $this->startAndEndDateDataLength;
        $this->clHeaderLength = 2;

        //チャプターデータサイズ (4byte)
        $this->chapterSizeIndex = $this->clHeaderIndex + $this->clHeaderLength;
        $this->chapterSizeLength = 4;

        //チャプターデータ
        $this->chapterDataIndex = $this->chapterSizeIndex + $this->chapterSizeLength;
        $arr = unpack( 'V', substr( $this->binary, $this->chapterSizeIndex, $this->chapterSizeLength ) );
        $this->chapterDataLength = $arr[ 1 ];

        //マイルストン
        $milestone = $this->chapterDataIndex + $this->chapterDataLength;

        //制作時に指定してある場合のみ存在します。
        if('bus' === substr($this->binary, $milestone, 3)){
            //質問フラグ
            $this->flgShitsumon = true;

            //busヘッダ(質問モードの目印)
            $this->busHeaderIndex = $milestone;
            $this->busHeaderLength = 3;

            //質問モードデータサイズ (4byte)
            $this->shitsumonSizeIndex = $this->busHeaderIndex + $this->busHeaderLength;
            $this->shitsumonSizeLength = 4;

            //質問モードデータ
            $this->shitsumonDataIndex = $this->shitsumonSizeIndex + $this->shitsumonSizeLength;
            $arr = unpack( 'V', substr( $this->binary, $this->shitsumonSizeIndex, $this->shitsumonSizeLength ) );
            $this->shitsumonDataLength = $arr[ 1 ];

            //マイルストン
            $milestone = $this->shitsumonDataIndex + $this->shitsumonDataLength;
        }

        //ブロックシーケンスデータサイズ (4byte)
        $this->blockSequenceSizeIndex = $milestone;
        $this->blockSequenceSizeLength = 4;

        //ブロックシーケンスデータ
        $this->blockSequenceDataIndex = $this->blockSequenceSizeIndex + $this->blockSequenceSizeLength;
        $arr = unpack( 'V', substr( $this->binary, $this->blockSequenceSizeIndex, $this->blockSequenceSizeLength ) );
        $this->blockSequenceDataLength = $arr[ 1 ];

        $cntKaigyo = 0;
        for ( $i = $this->blockSequenceDataIndex; $i < $this->blockSequenceDataIndex + $this->blockSequenceDataLength; ++$i ){
            $hex = bin2hex( substr( $this->binary, $i, 1 ) );
            if ('0d' === $hex){
                if ( $i + 1 < $this->blockSequenceDataIndex + $this->blockSequenceDataLength){
                    $hex = bin2hex( substr( $this->binary, $i + 1, 1 ) );
                    if('0a' === $hex){ ++$cntKaigyo;}
                }
            }
        }

        if(0 !== $cntKaigyo % 4){ throw new Exception('ブロックシーケンスに異常があります。'.__LINE__); }

        $this->countBlock = $cntKaigyo / 4;

        //早わかり識別フラグ(0 = なし/1 = あり)
        $this->hayawakariIndex = $this->blockSequenceDataIndex + $this->blockSequenceDataLength;
        $this->hayawakariLength = 1;
        $hex = bin2hex( substr( $this->binary, $this->hayawakariIndex, $this->hayawakariLength ) );
        if ( $hex != '00' ){
            $this->flgHayawakari = true;
        }

        //マイルストン
        $milestone = $this->hayawakariIndex + $this->hayawakariLength;

        //ブロックシーケンス数が１以上ある場合はコンテンツ用インデックスの配列を作成
        if(0 < $this->countBlock){
            $this->jpegSizeIndex = [];
            $this->jpegSizeLength = [];
            $this->jpegDataIndex = [];
            $this->jpegDataLength = [];
            $this->pmdSizeIndex = [];
            $this->pmdSizeLength = [];
            $this->pmdDataIndex = [];
            $this->pmdDataLength = [];
            $this->mp3x1SizeIndex = [];
            $this->mp3x1SizeLength = [];
            $this->mp3x1DataIndex = [];
            $this->mp3x1DataLength = [];

            if ($this->flgHayawakari){
                $this->mp3x2SizeIndex = [];
                $this->mp3x2SizeLength = [];
                $this->mp3x2DataIndex = [];
                $this->mp3x2DataLength = [];
                $this->mp3x4SizeIndex = [];
                $this->mp3x4SizeLength = [];
                $this->mp3x4DataIndex = [];
                $this->mp3x4DataLength = [];
            }
        }

        //ブロックシーケンス数ループ
        for($i = 0; $this->countBlock > $i; ++$i){
            //jpegデータサイズ
            $this->jpegSizeIndex[ $i ] = $milestone;
            $this->jpegSizeLength[ $i ] = 4;

            //jpegデータ
            $this->jpegDataIndex[ $i ] = $this->jpegSizeIndex[ $i ] + $this->jpegSizeLength[ $i ];
            $arr = unpack( 'V', substr( $this->binary, $this->jpegSizeIndex[ $i ], $this->jpegSizeLength[ $i ] ) );
            $this->jpegDataLength[ $i ] = $arr[ 1 ];

            //pmdデータサイズ
            $this->pmdSizeIndex[ $i ] = $this->jpegDataIndex[ $i ] + $this->jpegDataLength[ $i ];
            $this->pmdSizeLength[ $i ] = 4;

            //pmdデータ
            $this->pmdDataIndex[ $i ] = $this->pmdSizeIndex[ $i ] + $this->pmdSizeLength[ $i ];
            $arr = unpack( 'V', substr( $this->binary, $this->pmdSizeIndex[ $i ], $this->pmdSizeLength[ $i ] ) );
            $this->pmdDataLength[ $i ] = $arr[ 1 ];

            //mp3x1データサイズ
            $this->mp3x1SizeIndex[ $i ] = $this->pmdDataIndex[ $i ] + $this->pmdDataLength[ $i ];
            $this->mp3x1SizeLength[ $i ] = 4;

            //mp3x1データ
            $this->mp3x1DataIndex[ $i ] = $this->mp3x1SizeIndex[ $i ] + $this->mp3x1SizeLength[ $i ];
            $arr = unpack( 'V', substr( $this->binary, $this->mp3x1SizeIndex[ $i ], $this->mp3x1SizeLength[ $i ] ) );
            $this->mp3x1DataLength[ $i ] = $arr[ 1 ];

            //マイルストン
            $milestone = $this->mp3x1DataIndex[ $i ] + $this->mp3x1DataLength[ $i ];

            if ( true === $this->flgHayawakari ){
                //mp3x2データサイズ
                $this->mp3x2SizeIndex[ $i ] = $milestone;
                $this->mp3x2SizeLength[ $i ] = 4;

                //mp3x2データ
                $this->mp3x2DataIndex[ $i ] = $this->mp3x2SizeIndex[ $i ] + $this->mp3x2SizeLength[ $i ];
                $arr = unpack( 'V', substr( $this->binary, $this->mp3x2SizeIndex[ $i ], $this->mp3x2SizeLength[ $i ] ) );
                $this->mp3x2DataLength[ $i ] = $arr[ 1 ];

                //mp3x4データサイズ
                $this->mp3x4SizeIndex[ $i ] = $this->mp3x2DataIndex[ $i ] + $this->mp3x2DataLength[ $i ];
                $this->mp3x4SizeLength[ $i ] = 4;

                //mp3x4データ
                $this->mp3x4DataIndex[ $i ] = $this->mp3x4SizeIndex[ $i ] + $this->mp3x4SizeLength[ $i ];
                $arr = unpack( 'V', substr( $this->binary, $this->mp3x4SizeIndex[ $i ], $this->mp3x4SizeLength[ $i ] ) );
                $this->mp3x4DataLength[ $i ] = $arr[ 1 ];

                //マイルストン
                $milestone = $this->mp3x4DataIndex[ $i ] + $this->mp3x4DataLength[ $i ];
            }
        }

        if( substr( $this->binary, $this->ld1HeaderIndex, $this->ld1HeaderLength ) !== 'ld1'){
            throw new Exception('エラーです。'.__LINE__);
        }

        if(substr( $this->binary, $this->clHeaderIndex, $this->clHeaderLength ) !== 'cl' ){
            throw new Exception('エラーです。'.__LINE__);
        }

        $this->ready = true;
    }
}
?>