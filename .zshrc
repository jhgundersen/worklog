# Skip all this for non-interactive shells
[[ -z "$PS1" ]] && return

# Added directory for completion
fpath=(~/.zsh/completion $fpath)

# User specific aliases and functions
export CONFIG_HOME=/home/jonh/dev/xait/porter/dev/jonh/home
export CONFIG_BASE=/home/jonh/dev/xait/porter/dev/jonh/base
export CONFIG_HOME_DIR=phpunit
export PHP_IDE_CONFIG=serverName=Localhost 
export TNS_ADMIN=/xait/tns_admin
export PATH=$PATH:/opt/vagrant/bin:/usr/local/xait/php/bin:/home/jonh/programs/Sencha/Cmd/current:vendor/bin:/home/jonh/dev/arcanist/bin
export NLS_LANG=AMERICAN_AMERICA.UTF8
export GDK_USE_XFT=1

[[ -s "$HOME/.rvm/scripts/rvm" ]] && source "$HOME/.rvm/scripts/rvm" # Load RVM into a shell session *as a function*


# Version Control Info
autoload -Uz vcs_info
 
zstyle ':vcs_info:*' stagedstr '%F{28}●'
zstyle ':vcs_info:*' unstagedstr '%F{11}●'
zstyle ':vcs_info:*' check-for-changes true
zstyle ':vcs_info:(sv[nk]|bzr):*' branchformat '%b%F{1}:%F{11}%r'
zstyle ':vcs_info:*' enable git svn
precmd () {
    if [[ -z $(git ls-files --other --exclude-standard 2> /dev/null) ]] {
        zstyle ':vcs_info:*' formats ' [%F{green}%b%c%u%F{white}]'
    } else {
        zstyle ':vcs_info:*' formats ' [%F{green}%b%c%u%F{red}●%F{white}]'
    }
 
    vcs_info
}

# Prompt with version control info 
setopt prompt_subst
PS1=$'%F{def}%(?..%B%K{red}[%?]%K{def}%b )%(1j.%b%K{yel}%F{bla}%jJ%F{def}%K{def} .)%F{white}%B%*%b %F{m}%m:%F{white}%~%${vcs_info_msg_0_} %(!.#.>) %F{def}'

# Set less options
if [[ -x $(which less) ]]
then
    export PAGER="less"
    export LESS="--ignore-case --LONG-PROMPT --QUIET --chop-long-lines -Sm --RAW-CONTROL-CHARS --quit-if-one-screen --no-init"
    if [[ -x $(which lesspipe.sh) ]]
    then
	LESSOPEN="| lesspipe.sh %s"
	export LESSOPEN
    fi
fi

# General completion options
source ~/.zsh_completion

# Git flow completion
source ~/.git-flow-completion.zsh

# Aliases for zsh
source ~/.zsh_aliases

# Zsh spelling correction options
setopt CORRECT

# Say how long a command took, if it took more than 30 seconds
export REPORTTIME=2

# Prompts for confirmation after 'rm *' etc
# Helps avoid mistakes like 'rm * o' when 'rm *.o' was intended
setopt RM_STAR_WAIT

# Background processes aren't killed on exit of shell
setopt AUTO_CONTINUE

# Don’t write over existing files with >, use >! instead
setopt NOCLOBBER

# Don’t nice background processes
setopt NO_BG_NICE

# Watch other user login/out
watch=notme
export LOGCHECK=60

# When directory is changed set xterm title to host:dir
chpwd() {
    [[ -t 1 ]] || return
    case $TERM in
	sun-cmd) print -Pn "\e]l%~\e\\";;
        *xterm*|rxvt|(dt|k|E)term) print -Pn "\e]2;%m:%~\a";;
    esac
}


# Lines configured by zsh-newuser-install
HISTFILE=~/.histfile
HISTSIZE=25000
SAVEHIST=10000
setopt INC_APPEND_HISTORY
setopt HIST_IGNORE_ALL_DUPS
setopt HIST_IGNORE_SPACE
setopt HIST_REDUCE_BLANKS
setopt HIST_VERIFY

setopt autocd extendedglob notify
bindkey -e
# End of lines configured by zsh-newuser-install
# The following lines were added by compinstall
zstyle :compinstall filename '/home/jonh/.zshrc'

autoload -Uz compinit
compinit
# End of lines added by compinstall

PATH=$PATH:$HOME/.rvm/bin # Add RVM to PATH for scripting

