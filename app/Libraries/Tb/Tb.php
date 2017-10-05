<?php
namespace App\Libraries\Tb;
class Tb extends TbEntry
{
    public function setFile($file)
    {
        $this -> clear();
        if(true === file_exists($file)){
            try {
                $this->entry(file_get_contents($file));
            } catch ( Exeption $e ) {
                throw new Exception($e->getMessage());
            }
        }
        return($this);
    }

    public function setBinary($binary)
    {
        $this -> clear();
        try {
            $this->entry($binary);
        } catch ( Exeption $e ) {
            throw new Exception($e->getMessage());
        }
        return($this);
    }

    public function getBinary()
    {
        if (true !== $this->ready) {throw new Exception('ファイルが読み込まれておりません。'.__LINE__);}
        return($this->binary);
    }

    public function getPlayData(){
        if (true !== $this->ready) {throw new Exception('ファイルが読み込まれておりません。'.__LINE__);}

        $arr_block_sequence = explode(
            hex2bin ('0D0A'), //line break
            substr ($this->binary, $this->blockSequenceDataIndex, $this->blockSequenceDataLength)
        );
        array_pop ($arr_block_sequence);

        $arr_chapter = explode(
            hex2bin('0D0A'),//line break
            substr($this->binary, $this->chapterDataIndex, $this->chapterDataLength)
        );
        array_pop ($arr_chapter);
        array_pop ($arr_chapter);
        array_pop ($arr_chapter);
        $cnt_arr_chapter = count ($arr_chapter);


        for ($blocks = [], $i = 0; $i < $this->countBlock; ++$i) {
            $pause = (substr($arr_block_sequence[$i * 4], 0, 1) === "3");

            for ($chapter = null, $j = 2; $j < $cnt_arr_chapter; $j += 3) {
                if(intval(substr($arr_chapter[$j], 7, 2 ), 10) === $i) {
                    $chapter = mb_convert_encoding(substr($arr_chapter[$j - 1], 5), 'UTF-8', 'SJIS');
                    break;
                }
            }

            $blocks[$i] = [
                'image'   => substr ($this->binary, $this->jpegDataIndex[$i]   , $this->jpegDataLength[$i]   ),
                'audio'   => substr ($this->binary, $this->mp3x1DataIndex[$i]  , $this->mp3x1DataLength[$i]  ),
                'pen'     => substr ($this->binary, $this->pmdDataIndex[$i] + 4, $this->pmdDataLength[$i] - 4),// first 4byte is length data
                'pause'   => $pause  ,
                'chapter' => $chapter,
            ];
        }
        
        $final = null;
        if (true === $this->flgFinalScreen) {
            $final = [
                'image' => substr ($this->binary, $this->finalScreenDataIndex, $this->finalScreenDataLength )
            ];
        }

        return ( [
            'blocks' => $blocks      ,
            'final'  => $final       ,
            'loop' => $this->flgloop ,
        ] );
    }

    private function clear(){
        $this->binary                       = ''    ;

        $this->thinkBoardHeaderIndex        = 0     ;
        $this->thinkBoardHeaderLength       = 0     ;
        $this->editionHeaderIndex           = 0     ;
        $this->editionHeaderLength          = 0     ;
        $this->playerHeaderIndex            = 0     ;
        $this->playerHeaderLength           = 0     ;
        $this->contentsHeaderIndex          = 0     ;
        $this->contentsHeaderLength         = 0     ;
        $this->helpMessageSizeIndex         = 0     ;
        $this->helpMessageSizeLength        = 0     ;
        $this->helpMessageDataIndex         = 0     ;
        $this->helpMessageDataLength        = 0     ;
        $this->autoEndSizeIndex             = 0     ;
        $this->autoEndSizeLength            = 0     ;
        $this->autoEndDataIndex             = 0     ;
        $this->autoEndDataLength            = 0     ;
        $this->urlSizeIndex                 = 0     ;
        $this->urlSizeLength                = 0     ;
        $this->urlDataIndex                 = 0     ;
        $this->urlDataLength                = 0     ;
        $this->pclpmSizeIndex               = 0     ;
        $this->pclpmSizeLength              = 0     ;
        $this->pclpmDataIndex               = 0     ;
        $this->pclpmDataLength              = 0     ;
        $this->engHelpSizeIndex             = 0     ;
        $this->engHelpSizeLength            = 0     ;
        $this->engHelpDataIndex             = 0     ;
        $this->engHelpDataLength            = 0     ;
        $this->jpnHelpSizeIndex             = 0     ;
        $this->jpnHelpSizeLength            = 0     ;
        $this->jpnHelpDataIndex             = 0     ;
        $this->jpnHelpDataLength            = 0     ;
        $this->lpfHeaderIndex               = 0     ;
        $this->lpfHeaderLength              = 0     ;
        $this->loopIndex                    = 0     ;
        $this->loopLength                   = 0     ;
        $this->qsfHeaderIndex               = 0     ;
        $this->qsfHeaderLength              = 0     ;
        $this->baisokuIndex                 = 0     ;
        $this->baisokuLength                = 0     ;
        $this->pcgHeaderIndex               = 0     ;
        $this->pcgHeaderLength              = 0     ;
        $this->finalScreenIndex             = 0     ;
        $this->finalScreenLength            = 0     ;
        $this->finalScreenSizeIndex         = 0     ;
        $this->finalScreenSizeLength        = 0     ;
        $this->finalScreenDataIndex         = 0     ;
        $this->finalScreenDataLength        = 0     ;
        $this->ulcHeaderIndex               = 0     ;
        $this->ulcHeaderLength              = 0     ;
        $this->urlColorSizeIndex            = 0     ;
        $this->urlColorSizeLength           = 0     ;
        $this->urlColorDataIndex            = 0     ;
        $this->urlColorDataLength           = 0     ;
        $this->ppwHeaderIndex               = 0     ;
        $this->ppwHeaderLength              = 0     ;
        $this->passwordSizeIndex            = 0     ;
        $this->passwordSizeLength           = 0     ;
        $this->passwordDataIndex            = 0     ;
        $this->passwordDataLength           = 0     ;
        $this->ld0HeaderIndex               = 0     ;
        $this->ld0HeaderLength              = 0     ;
        $this->unknownSizeIndex             = 0     ;
        $this->unknownSizeLength            = 0     ;
        $this->unknownDataIndex             = 0     ;
        $this->unknownDataLength            = 0     ;
        $this->ld1HeaderIndex               = 0     ;
        $this->ld1HeaderLength              = 0     ;
        $this->startAndEndDateSizeIndex     = 0     ;
        $this->startAndEndDateSizeLength    = 0     ;
        $this->startAndEndDateDataIndex     = 0     ;
        $this->startAndEndDateDataLength    = 0     ;
        $this->clHeaderIndex                = 0     ;
        $this->clHeaderLength               = 0     ;
        $this->chapterSizeIndex             = 0     ;
        $this->chapterSizeLength            = 0     ;
        $this->chapterDataIndex             = 0     ;
        $this->chapterDataLength            = 0     ;
        $this->busHeaderIndex               = 0     ;
        $this->busHeaderLength              = 0     ;
        $this->shitsumonSizeIndex           = 0     ;
        $this->shitsumonSizeLength          = 0     ;
        $this->shitsumonDataIndex           = 0     ;
        $this->shitsumonDataLength          = 0     ;
        $this->blockSequenceSizeIndex       = 0     ;
        $this->blockSequenceSizeLength      = 0     ;
        $this->blockSequenceDataIndex       = 0     ;
        $this->blockSequenceDataLength      = 0     ;
        $this->hayawakariIndex              = 0     ;
        $this->hayawakariLength             = 0     ;

        $this->flgloop                      = false ;
        $this->flgBaisoku                   = false ;
        $this->flgFinalScreen               = false ;
        $this->flgShitsumon                 = false ;
        $this->flgHayawakari                = false ;

        $this->countBlock                   = 0     ;

        $this->jpegSizeIndex                = []    ;
        $this->jpegSizeLength               = []    ;
        $this->jpegDataIndex                = []    ;
        $this->jpegDataLength               = []    ;
        $this->pmdSizeIndex                 = []    ;
        $this->pmdSizeLength                = []    ;
        $this->pmdDataIndex                 = []    ;
        $this->pmdDataLength                = []    ;
        $this->mp3x1SizeIndex               = []    ;
        $this->mp3x1SizeLength              = []    ;
        $this->mp3x1DataIndex               = []    ;
        $this->mp3x1DataLength              = []    ;
        $this->mp3x2SizeIndex               = []    ;
        $this->mp3x2SizeLength              = []    ;
        $this->mp3x2DataIndex               = []    ;
        $this->mp3x2DataLength              = []    ;
        $this->mp3x4SizeIndex               = []    ;
        $this->mp3x4SizeLength              = []    ;
        $this->mp3x4DataIndex               = []    ;
        $this->mp3x4DataLength              = []    ;

        $this->ready                        = false ;
    }
}
?>