<?php

namespace Illuminate\View\Compilers\Concerns;

trait CompilesErrors
{
    /**
     * Compile the error statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileError($expression)
    {
        $expression = $this->stripParentheses($expression);

        return '<?php if ($errors->has('.$expression.')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('.$expression.'); ?>';
    }

    /**
     * Compile the enderror statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileEnderror($expression)
    {
        return '<?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>';
    }
    
    /**
     * Compile the errorbag statement into valid PHP.
     *
     * @param string $expression
     * @return string
     */
    protected function compileErrorbag($expression)
    {
        $expression = explode(',', $this->stripParentheses($expression));
        $bag = Arr::get($expression, 0);
        $attribute = trim(Arr::get($expression, 1));
        
        return '<?php if ($errors->getBag('.$bag.')->has('.$attribute.')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->getBag('.$bag.')->first('.$attribute.'); ?>';
    }

    /**
     * Compile the enderrorbag statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileEnderrorbag($expression)
    {
        return $this->compileEnderror($expression);
    }
}
