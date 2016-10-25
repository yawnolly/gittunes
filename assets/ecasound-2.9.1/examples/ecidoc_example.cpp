/*************************************************************************
 * Implementation of the following:
 * 
 * 1. Setup ECI to read audio from file, apply a 100Hz lowpass filter, and 
 *    send it to the soundcard (/dev/dsp).
 * 2. Every second, check the current position. If the stream has
 *    been running for over 15 seconds, exit immediately. Also,
 *    every second, increase the lowpass filter's cutoff frequency
 *    by 500Hz.
 * 3. Stop the stream (if not already finished) and disconnect the 
 *    chainsetup. Print chain operator status info.
 ************************************************************************/

#include <iostream>
#include <unistd.h>
#include <eca-control-interface.h>

/* compile with: 
 *
 * c++ -o ecidoc_example ecidoc_example.cpp `libecasoundc-config --cflags --libs`
 */

int main(int argc, char *argv[])
{
  double cutoff_inc = 500.0;

  ECA_CONTROL_INTERFACE e;
  e.command("cs-add play_chainsetup");
  e.command("c-add 1st_chain");
  e.command("ai-add foo.wav");
  e.command("ao-add /dev/dsp");
  e.command("cop-add -efl:100");
  e.command("cop-select 1");
  e.command("copp-select 1");
  e.command("cs-connect");
  e.command("start");
  while(1) {
    sleep(1);
    e.command("engine-status");
    if (e.last_string() != "running") break;
    e.command("get-position");
    double curpos = e.last_float();
    if (curpos > 15.0) break;
    e.command("copp-get");
    double next_cutoff = cutoff_inc + e.last_float();
    e.command_float_arg("copp-set", next_cutoff);
  }
  
  e.command("stop");
  e.command("cs-disconnect");
  e.command("cop-status");
  std::cerr << "Chain operator status: " << e.last_string() << std::endl;

  return(0);
}
