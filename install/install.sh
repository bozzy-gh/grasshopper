#!/bin/bash
{
	#////////////////////////////////////
	# Grasshopper Installation Script
	#
	#////////////////////////////////////
	# Created by Dan Knight / daniel_haze@hotmail.com / fuzon.co.uk
	#
	#////////////////////////////////////
	#
	# Info:
	# - Installs and setups up grasshopper
	#
	# Usage:
	# ./install.sh
	#////////////////////////////////////

	#/////////////////////////////////////////////////////////////////////////////////////
	# Defines
	#/////////////////////////////////////////////////////////////////////////////////////
	#Filepaths
	FILEPATH_GRASSHOPPER="/var/www"
	FILEPATH_LOGS="/var/log/grasshopper"

	#Exit path for non-root privileges.
	if (( $UID != 0 )); then
		echo -e "\nGrasshopper installation script must be run with root privileges.\n\nPlease run:\nsudo $FILEPATH_GRASSHOPPER/install/install.sh\n"
		exit
	fi
	
	#/////////////////////////////////////////////////////////////////////////////////////
	# Install_Permissions
	#/////////////////////////////////////////////////////////////////////////////////////
	Install_Permissions(){

		#-----------------------------------------------------------------------
		#Set www-data access to all files and folders in /var/www
		chown -R www-data:www-data "$FILEPATH_GRASSHOPPER"

		#Generate an Array which contains a list of permissions for files/folders.
		#NOTE:
		# - Generally, set everything to read only.
		# - Add files to the bottom of this list that require read/write access (eg: configs and files that change)
		declare -a Permission_Array=(
			"400 $FILEPATH_GRASSHOPPER/favicon.ico"
			"500 $FILEPATH_GRASSHOPPER/index.php"
			"500 $FILEPATH_GRASSHOPPER/css"
			"500 $FILEPATH_GRASSHOPPER/documentation"
			"500 $FILEPATH_GRASSHOPPER/exec"
			"500 $FILEPATH_GRASSHOPPER/includes"
			"755 $FILEPATH_GRASSHOPPER/install"
			"500 $FILEPATH_GRASSHOPPER/js"
			"500 $FILEPATH_GRASSHOPPER/phpliteadmin"
			"400 $FILEPATH_GRASSHOPPER/pics"
			"500 $FILEPATH_GRASSHOPPER/setup"
			"500 $FILEPATH_GRASSHOPPER/themes"
			"700 $FILEPATH_GRASSHOPPER/includes/myhome.conf"
			"700 $FILEPATH_GRASSHOPPER/exec/ownGateway.conf"
		)

		#Run and apply permissions.
		for ((i=0; i<${#Permission_Array[@]}; i++))
		do
			chmod -R ${Permission_Array[$i]}
		done

		#delete [] array
		unset Permission_Array
	}

	#/////////////////////////////////////////////////////////////////////////////////////
	# Install_Service
	#/////////////////////////////////////////////////////////////////////////////////////
	Install_Service(){
		#Setup grasshopper system service
		cp "$FILEPATH_GRASSHOPPER"/install/service.sh /etc/init.d/grasshopper
		chmod +x /etc/init.d/grasshopper
		update-rc.d grasshopper defaults 80 10
	}
	
	#/////////////////////////////////////////////////////////////////////////////////////
	# Main Loop
	#/////////////////////////////////////////////////////////////////////////////////////

	#-----------------------------------------------------------------------
	#Create grasshopper log folder
	mkdir -p "$FILEPATH_LOGS"

	#-----------------------------------------------------------------------
	#Setup system service
	Install_Service
	
	#-----------------------------------------------------------------------
	#Setup Permissions
	Install_Permissions
	
	#-----------------------------------------------------------------------
	#Remove install folder/files?
	#rm -R "$FILEPATH_GRASSHOPPER"/install

	#-----------------------------------------------------------------------
	exit
	#-----------------------------------------------------------------------
}